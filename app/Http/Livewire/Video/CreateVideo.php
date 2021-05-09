<?php

namespace App\Http\Livewire\Video;

use App\Jobs\ConvertVideoForStreaming;
use App\Jobs\CreateThumbnailFromVideo;
use App\Models\Channel;
use App\Models\Video;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateVideo extends Component
{
    use WithFileUploads;

    public Channel $channel;

    public Video $video;

    public $videoFile;

    protected $rules = [

        'videoFile' => 'required|mimes:mp4|max:1228800'

    ];

    public function mount(Channel $channel)
    {

        $this->channel = $channel;
    }

    public function render()
    {

        return view('livewire.video.create-video')->extends('layouts.app');

    }

    public function fileCompleted()
    {
        // 驗證資料

        $this->validate();

        // 儲存影片

        $path = $this->videoFile->store('video-temp');

        // 儲存至資料庫

        $this->video = $this->channel->videos()->create([

            'title' => 'untitled',

            'description' => 'none',

            'uid' => uniqid(true),

            'visibility' => 'private',

            'path' => explode('/', $path)[1],

        ]);

        // 加入 jobs

        CreateThumbnailFromVideo::dispatch($this->video);

        ConvertVideoForStreaming::dispatch($this->video);

        // 重新導向至 controller

        return redirect()->route('video.edit', [

            'channel' => $this->channel,

            'video' => $this->video,

        ]);

    }

}
