@include('layouts.header')
<div class="container py-4">
    <h2>Event</h2>
    <form class='form' method="POST" action="{{url('/admin/save-event')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title"
                   value="{{old('title')?old('title'):(isset($title)?$title:'')}}"
                   name="title" required>
        </div>

        <div class="form-group mb-3">
            <label for="events_topic_id">Topic: </label>
            <select name="events_topic_id" id="events_topic_id">
                <?php foreach ($topics as $topic) :
                $saved_id = old('events_topic_id') ? old('events_topic_id') : (isset($events_topic_id) ? $events_topic_id : '-1')?>
                @if($saved_id==$topic->id)
                    <option value="{{$topic->id}}" selected>{{$topic->title_ua}}</option>
                @else
                    <option value="{{$topic->id}}">{{$topic->title_ua}}</option>
                @endif
            <!--<option value="{{$topic->id}}">{{$topic->title_ru}}</option>-->
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="media_type">Media type: </label>
            <select name="media_type" id="media_type">
                <?php $saved_id = old('media_type') ? old('media_type') : (isset($media_type) ? $media_type : 'youtube')?>
                @if($saved_id=='youtube')
                    <option value="youtube" selected>Youtube</option>
                @else
                    <option value="youtube">Youtube</option>
                @endif

                @if($saved_id=='audio')
                    <option value="audio" selected>Audio</option>
                @else
                    <option value="audio">Audio</option>
                @endif

                @if($saved_id=='video')
                    <option value="video" selected>Video</option>
                @else
                    <option value="video">Video</option>
                @endif

                @if($saved_id=='image')
                    <option value="image" selected>Image</option>
                @else
                    <option value="image">Image</option>
                @endif
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="url">Url:</label>
            <input type="text" class="form-control" id="url"
                   value="{{old('url')?old('url'):(isset($url)?$url:'')}}"
                   name="url" required>
        </div>

        <div class="form-group mb-3">
            <label for="body">Description:</label>
            <textarea class="form-control" id="body" name="body" required
            >{{old('body')?old('body'):(isset($body)?$body:'')}}</textarea>
        </div>

        <div class="form-group">
            <button style="cursor:pointer;" id="save_changes" type="submit" class="btn btn-primary">Save</button>
        </div>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>

    <input type="file" name="file" id="file_input">

</div>

<script>
    function onChangeMediaType() {
        if (document.querySelector('#media_type').value == 'youtube') {
            document.querySelector("#url").style.display = "block";
            document.querySelector("#file_input").style.display = "none";
        } else {
            document.querySelector("#url").style.display = "none";
            document.querySelector("#file_input").style.display = "block";
            //change accept file_input for audio/image/video
        }
    }

    document.querySelector("#media_type").addEventListener("change", ()=> {
        document.querySelector("#url").value = "";
        onChangeMediaType();
    });
    onChangeMediaType();
</script>

@include('layouts.footer')
