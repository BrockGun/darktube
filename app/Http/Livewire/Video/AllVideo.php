<?php

namespace App\Http\Livewire\Video;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Video;
use Illuminate\Support\Facades\Storage;

class AllVideo extends Component
{

    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        return view('livewire.video.all-video')
            ->with('videos', auth()->user()->channel->videos()->paginate(1))
            ->extends('layouts.app');
    }

    public function delete(Video $video)
    {
        // 刪除資料夾
        $deleted = Storage::disk('videos')->deleteDirectory($video->uid);

        if($deleted)
        {
            $video->delete();
        }

        return back();
    }
}
