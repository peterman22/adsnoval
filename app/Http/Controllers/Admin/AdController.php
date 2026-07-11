<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
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
        if ($r->hasFile('video')){ $d['body']=$this->storeVideo($r->file('video')); $d['type']=4; }
        unset($d['video']);
        $d['views_left']=$d['max_views']; $d['status']=$r->boolean('active',true)?1:0;
        Ad::create($d);
        return back()->with('success','Ad created.');
    }

    public function update(Request $r,Ad $ad){
        // A new upload replaces the body; otherwise the existing body stays required.
        $d=$r->validate($this->rules(bodyRequired: ! $r->hasFile('video')));
        if ($r->hasFile('video')){
            $this->deleteVideo($ad->body);           // clean up the old uploaded file, if any
            $d['body']=$this->storeVideo($r->file('video')); $d['type']=4;
        }
        unset($d['video']);
        $d['views_left']=max(0,$d['max_views']-$ad->views_done); // keep already-served views
        $d['status']=$r->boolean('active')?1:0;
        $ad->update($d);
        return back()->with('success','Ad updated.');
    }

    public function destroy(Ad $ad){ $this->deleteVideo($ad->body); $ad->delete(); return back()->with('success','Ad deleted.'); }

    /** Save an uploaded video into public/assets/ads and return its URL. */
    protected function storeVideo(UploadedFile $file): string {
        $dir = public_path('assets/ads');
        if (! is_dir($dir)) @mkdir($dir, 0755, true);
        $ext = strtolower($file->getClientOriginalExtension() ?: 'mp4');
        $name = 'ad_'.date('Ymd_His').'_'.Str::random(6).'.'.$ext;
        $file->move($dir, $name);
        return asset('assets/ads/'.$name);
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
