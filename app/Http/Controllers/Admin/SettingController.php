<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\{Setting,EmailTemplate};
use App\Services\Mailer;
use Illuminate\Http\Request;
class SettingController extends Controller {
    public function index(){ return view('admin.settings',['s'=>fn($k,$d='')=>Setting::val($k,$d)]); }
    public function save(Request $r){
        foreach($r->except('_token') as $k=>$v) Setting::updateOrCreate(['key'=>$k],['value'=>$v]);
        return back()->with('success','Settings saved.');
    }
    public function templates(){ return view('admin.templates',['templates'=>EmailTemplate::all()]); }
    public function saveTemplate(Request $r,EmailTemplate $template){
        $template->update($r->validate([
            'subject'=>'required|string|max:191','body'=>'required|string','is_active'=>'nullable',
        ])+['is_active'=>$r->boolean('is_active')]);
        return back()->with('success','Template saved.');
    }

    /** Send a plain diagnostic email to verify the saved SMTP credentials. */
    public function testMail(Request $r){
        $data = $r->validate(['test_email'=>'required|email']);
        if (! Setting::val('mail_host'))
            return back()->with('error','Set and save your SMTP host first, then send a test.');
        $site = Setting::val('site_name','AdsNoval');
        $subject = $site.' — SMTP test email';
        $body = Mailer::wrapHtml(
            '<h2 style="color:#fff;margin-top:0">SMTP is working</h2>'
            .'<p>If you can read this, your '.e($site).' SMTP settings are configured correctly.</p>'
            .'<p style="color:#93a0b8;font-size:12px">Sent '.now()->toDayDateTimeString().' from host <b>'.e(Setting::val('mail_host')).'</b>.</p>',
            $subject);
        try {
            Mailer::sendHtml($data['test_email'], $subject, $body);
            return back()->with('success','Test email sent to '.$data['test_email'].'. Check the inbox (and spam folder).');
        } catch (\Throwable $e){
            return back()->with('error','SMTP test failed: '.$e->getMessage());
        }
    }

    /** Render one template with sample data straight to the browser (no email sent). */
    public function previewTemplate(EmailTemplate $template){
        [, $body] = Mailer::renderTemplate($template, Mailer::sampleVars());
        return response($body);
    }

    /** Send one template (rendered with sample data) to a chosen address. */
    public function testTemplate(Request $r, EmailTemplate $template){
        $data = $r->validate(['test_email'=>'required|email']);
        if (! Setting::val('mail_host'))
            return back()->with('error','Set and save your SMTP host first, then send a test.');
        [$subject, $body] = Mailer::renderTemplate($template, Mailer::sampleVars());
        try {
            Mailer::sendHtml($data['test_email'], '[TEST] '.$subject, $body);
            return back()->with('success','“'.$template->name.'” sent to '.$data['test_email'].'.');
        } catch (\Throwable $e){
            return back()->with('error','Send failed: '.$e->getMessage());
        }
    }
}
