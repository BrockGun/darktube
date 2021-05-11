
<div class="container" @if($video->processing_percentage < 100) wire:poll.500ms @endif>

    <div class="row justify-content-center">

        <div class="col-md-8">

            <div class="row">

                <div class="col-md-12">

                    <img class="img-thumbnail" src="{{ asset($this->video->thumbnail) }}" alt="">

                </div>

                <div class="progress my-4 col-md-12">

                    <div class="progress-bar" role="progressbar" style="width: {{$this->video->processing_percentage}}%"></div>

                </div>


            </div>

            <form wire:submit.prevent="update">

                <div class="form-group">

                    <label for="title">Title</label>

                    <input type="text" class="form-control" wire:model="video.title">

                </div>

                @error('video.title')

                    <div class="alert alert-danger">

                        {{$message}}

                    </div>

                @enderror

                <div class="form-group">

                    <label for="description">Description</label>

                    <textarea cols="30" rows="4" class="form-control" wire:model="video.description"></textarea>

                </div>

                @error('video.description')

                    <div class="alert alert-danger">

                        {{$message}}

                    </div>

                @enderror


                <div class="form-group">

                    <label for="visibility">Visibility</label>

                    <select wire:model="video.visibility">

                        <option value="private">private</option>

                        <option value="public">public</option>

                        <option value="unlisted">unlisted</option>

                    </select>

                </div>

                @error('video.description')

                    <div class="alert alert-danger">

                        {{$message}}

                    </div>

                @enderror

                <div class="form-group">

                    <button type="submit" class="btn btn-primary">Update</button>

                </div>

                @if(session()->has('message'))

                    <div class="alert alert-success">

                        {{ session('message') }}

                    </div>

                @endif

            </form>

        </div>

    </div>

</div>
