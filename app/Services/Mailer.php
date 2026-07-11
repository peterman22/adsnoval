<?php

namespace App\Services;

use App\Models\EmailTemplate;
use App\Models\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

/**
 * Sends templated emails through the SMTP credentials stored in settings.
 * Templates support {{placeholder}} substitution.
 */
class Mailer
{
    public static function configureSmtp(): void
    {
        if (Setting::val('mail_host')) {
            Config::set('mail.default', 'smtp');
            Config::set('mail.mailers.smtp.host', Setting::val('mail_host'));
            Config::set('mail.mailers.smtp.port', (int) Setting::val('mail_port', 587));
            Config::set('mail.mailers.smtp.username', Setting::val('mail_username'));
            Config::set('mail.mailers.smtp.password', Setting::val('mail_password'));
            Config::set('mail.mailers.smtp.encryption', Setting::val('mail_encryption', 'tls'));
        }
        Config::set('mail.from.address', Setting::val('mail_from_address', 'no-reply@example.com'));
        Config::set('mail.from.name', Setting::val('mail_from_name', Setting::val('site_name', config('app.name'))));
    }

    /**
     * Render a template and send it. Silently logs failures so app flows
     * (register, deposit approval, etc.) never break because of email.
     */
    public static function sendTemplate(string $to, string $key, array $vars = []): bool
    {
        $tpl = EmailTemplate::where('key', $key)->where('is_active', true)->first();
        if (! $tpl) return false;

        $vars = array_merge([
            'site_name' => Setting::val('site_name', config('app.name')),
            'year'      => date('Y'),
        ], $vars);

        $subject = self::render($tpl->subject, $vars);
        $body    = self::wrap(self::render($tpl->body, $vars), $subject);

        try {
            self::configureSmtp();
            Mail::html($body, function ($m) use ($to, $subject) {
                $m->to($to)->subject($subject);
            });
            return true;
        } catch (\Throwable $e) {
            Log::warning('Email send failed ['.$key.']: '.$e->getMessage());
            return false;
        }
    }

    protected static function render(string $text, array $vars): string
    {
        foreach ($vars as $k => $v) {
            $text = str_replace('{{'.$k.'}}', (string) $v, $text);
        }
        return $text;
    }

    /** Wrap template body in a branded responsive HTML shell. */
    protected static function wrap(string $inner, string $title): string
    {
        $site = e(Setting::val('site_name', config('app.name')));
        return '<!doctype html><html><body style="margin:0;background:#0b0f1c;font-family:Arial,Helvetica,sans-serif;color:#e8edf9">'
            .'<div style="max-width:560px;margin:0 auto;padding:30px">'
            .'<div style="text-align:center;margin-bottom:22px"><span style="display:inline-block;padding:10px 18px;border-radius:12px;background:linear-gradient(135deg,#ff9d4d,#ff7a1a);color:#1a1205;font-weight:800;font-size:18px">▲ '.$site.'</span></div>'
            .'<div style="background:#141b2d;border:1px solid rgba(255,255,255,.08);border-radius:18px;padding:28px;line-height:1.6">'.$inner.'</div>'
            .'<p style="text-align:center;color:#5f6c85;font-size:12px;margin-top:20px">© '.date('Y').' '.$site.'. All rights reserved.</p>'
            .'</div></body></html>';
    }
}
