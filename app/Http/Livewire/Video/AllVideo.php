<?php

namespace App\Http\Livewire\Video;

use App\Models\Channel;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AllVideo extends Component
{

    use WithPagination;

    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';

    public $channel;

    public function mount(Channel $channel)
    {
        $this->channel = $channel;
    }

    public function render()
    {
        return view('livewire.video.all-video')
            ->with('videos', $this->channel->videos()->paginate(5))
            ->extends('layouts.app');
    }

    public function delete(Video $video)
    {
        // 確認使用者是否能刪除該影片

        $this->authorize('delete', $video);

        // 刪除資料夾
        $deleted = Storage::disk('videos')->deleteDirectory($video->uid);

        if($deleted)
        {
            $video->delete();
        }

        return back();
    }
}
