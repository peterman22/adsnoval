<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
class AdController extends Controller {
    public function index(){ return view('admin.ads',['ads'=>Ad::latest()->paginate(20)]); }
    protected function rules(bool $bodyRequired){ return [
        'title'=>'required|string|max:120','type'=>'required|in:1,2,3,4',
        'body'=>($bodyRequired?'required':'nullable').'|string',
        'video'=>'nullable|file|mimetypes:video/mp4,video/webm,video/ogg|max:102400', // up to 100 MB
        'reward'=>'required|numeric|min:0','duration'=>'required|integer|min:1','max_views'=>'required|integer|min:1',
    ]; }

    public function store(Request $r){
        // Body is optional when a video file is uploaded instead.
        $d=$r->validate($this->rules(bodyRequired: ! $r->hasFile('video')));
        $note=''; $v=null;
        if ($r->hasFile('video')){ $v=$this->storeVideo($r->file('video')); $d['body']=$v['url']; $d['type']=4; $note=$this->savingsNote($v); }
        unset($d['video']);
        $d['views_left']=$d['max_views']; $d['status']=$r->boolean('active',true)?1:0;
        Ad::create($d);
        return back()->with('success','Ad created.'.$note);
    }

    public function update(Request $r,Ad $ad){
        // A new upload replaces the body; otherwise the existing body stays required.
        $d=$r->validate($this->rules(bodyRequired: ! $r->hasFile('video')));
        $note='';
        if ($r->hasFile('video')){
            $this->deleteVideo($ad->body);           // clean up the old uploaded file, if any
            $v=$this->storeVideo($r->file('video')); $d['body']=$v['url']; $d['type']=4; $note=$this->savingsNote($v);
        }
        unset($d['video']);
        $d['views_left']=max(0,$d['max_views']-$ad->views_done); // keep already-served views
        $d['status']=$r->boolean('active')?1:0;
        $ad->update($d);
        return back()->with('success','Ad updated.'.$note);
    }

    public function destroy(Ad $ad){ $this->deleteVideo($ad->body); $ad->delete(); return back()->with('success','Ad deleted.'); }

    /**
     * Save an uploaded video into public/assets/ads. If FFmpeg is available
     * the file is re-encoded much smaller (H.264, scaled down); otherwise the
     * original is kept. Returns url + raw/final byte sizes + whether it shrank.
     */
    protected function storeVideo(UploadedFile $file): array {
        @set_time_limit(600); // transcoding a large clip can take a while
        $dir = public_path('assets/ads');
        if (! is_dir($dir)) @mkdir($dir, 0755, true);

        $base   = 'ad_'.date('Ymd_His').'_'.Str::random(6);
        $srcExt = strtolower($file->getClientOriginalExtension() ?: 'mp4');
        $rawName= $base.'_raw.'.$srcExt;
        $file->move($dir, $rawName);
        $rawPath = $dir.DIRECTORY_SEPARATOR.$rawName;
        $rawBytes = (int) @filesize($rawPath);

        $bin = $this->ffmpegBin();
        if ($bin) {
            $finalName = $base.'.mp4';
            $finalPath = $dir.DIRECTORY_SEPARATOR.$finalName;
            if ($this->transcode($bin, $rawPath, $finalPath) && is_file($finalPath) && @filesize($finalPath) > 0) {
                @unlink($rawPath);
                return ['url'=>asset('assets/ads/'.$finalName), 'raw'=>$rawBytes, 'final'=>(int)@filesize($finalPath), 'compressed'=>true, 'ffmpeg'=>true];
            }
            @unlink($finalPath); // transcode failed — fall back to the original
        }

        // Fallback: serve the original upload untouched.
        $keepName = $base.'.'.$srcExt;
        @rename($rawPath, $dir.DIRECTORY_SEPARATOR.$keepName);
        return ['url'=>asset('assets/ads/'.$keepName), 'raw'=>$rawBytes, 'final'=>$rawBytes, 'compressed'=>false, 'ffmpeg'=>(bool)$bin];
    }

    /** Re-encode $in into a smaller H.264 mp4 at $out. Returns success. */
    protected function transcode(string $bin, string $in, string $out): bool {
        $crf   = (int) env('AD_VIDEO_CRF', 30);        // 23=high quality … 32=small; 28-32 is a good range
        $maxW  = (int) env('AD_VIDEO_MAX_WIDTH', 854); // cap width (854 ≈ 480p). Use 1280 for 720p
        $abr   = (int) env('AD_VIDEO_AUDIO_KBPS', 96);

        $proc = new Process([
            $bin, '-y', '-i', $in,
            '-vcodec', 'libx264', '-crf', (string) $crf, '-preset', 'veryfast',
            '-vf', "scale='min($maxW,iw)':-2",          // downscale only if wider; keep aspect, even height
            '-pix_fmt', 'yuv420p',                        // broad player compatibility
            '-acodec', 'aac', '-b:a', $abr.'k',
            '-movflags', '+faststart',                    // lets it start playing before fully downloaded
            $out,
        ]);
        $proc->setTimeout(600);
        try {
            $proc->run();
            if (! $proc->isSuccessful()) {
                Log::warning('FFmpeg transcode failed: '.$proc->getErrorOutput());
                return false;
            }
            return true;
        } catch (\Throwable $e) {
            Log::warning('FFmpeg transcode error: '.$e->getMessage());
            return false;
        }
    }

    /** Locate a working ffmpeg binary (FFMPEG_PATH env, else "ffmpeg" on PATH). */
    protected function ffmpegBin(): ?string {
        foreach (array_filter([env('FFMPEG_PATH'), 'ffmpeg']) as $bin) {
            try {
                $p = new Process([$bin, '-version']);
                $p->setTimeout(15);
                $p->run();
                if ($p->isSuccessful()) return $bin;
            } catch (\Throwable $e) { /* try next candidate */ }
        }
        return null;
    }

    /** Human-readable note about the compression result, for the flash message. */
    protected function savingsNote(array $v): string {
        $fmt = fn(int $b) => $b >= 1048576 ? round($b/1048576, 2).' MB' : max(1, (int) round($b/1024)).' KB';
        if ($v['compressed'] && $v['raw'] > 0 && $v['final'] < $v['raw']) {
            $pct = (int) round((1 - $v['final'] / $v['raw']) * 100);
            return ' Video compressed '.$fmt($v['raw']).' → '.$fmt($v['final']).' ('.$pct.'% smaller).';
        }
        if (! $v['ffmpeg']) {
            return ' (Stored uncompressed — FFmpeg not found on the server. Install it to shrink uploads.)';
        }
        return ' Video stored ('.$fmt($v['final']).').';
    }

    /** Remove a previously uploaded video file when its ad is replaced or deleted. */
    protected function deleteVideo(?string $body): void {
        if (! $body) return;
        $path = parse_url($body, PHP_URL_PATH) ?: '';
        if (! str_contains($path, '/assets/ads/')) return; // only touch our own uploads
        $file = public_path('assets/ads/'.basename($path));
        if (is_file($file)) @unlink($file);
    }
}
