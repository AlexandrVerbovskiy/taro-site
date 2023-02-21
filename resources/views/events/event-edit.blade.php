@extends('layouts.admin')
@section('content')
<div class="container py-4 message-parent">
    @include("layouts.error-message")
    <h2 style="margin-bottom: 24px; margin-top: 56px">Події</h2>
    <form class='form' method="POST" action="{{url('/admin/save-event')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="title">Заголовок:</label>
            <input type="text" class="form-control" id="title"
                   value="{{old('title')?old('title'):(isset($title)?$title:'')}}"
                   name="title" required>
        </div>

        <div class="form-group mb-3">
            <label for="events_topic_id">Розділ: </label>
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
            <label for="media_type">Тип файлу: </label>
            <select name="media_type" id="media_type">
                <?php $saved_id = old('media_type') ? old('media_type') : (isset($media_type) ? $media_type : 'youtube')?>
                @if($saved_id=='youtube')
                    <option value="youtube" selected>Ютуб</option>
                @else
                    <option value="youtube">Ютуб</option>
                @endif

                @if($saved_id=='audio')
                    <option value="audio" selected>Аудіо</option>
                @else
                    <option value="audio">Аудіо</option>
                @endif

                @if($saved_id=='video')
                    <option value="video" selected>Відео</option>
                @else
                    <option value="video">Відео</option>
                @endif

                @if($saved_id=='image')
                    <option value="image" selected>Фото</option>
                @else
                    <option value="image">Фото</option>
                @endif
            </select>
        </div>

        <div class="form-group mb-3 youtube" style="display: none">
            <label for="url">Url:</label>
            <input style="margin-bottom: 10px" type="text" class="form-control" id="url"
                   value="{{old('url')?old('url'):(isset($url)?$url:'')}}"
                   name="url" required>
            <iframe id="youtube_media_view" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen></iframe>
        </div>

        <div class="form-group mb-3 image" style="display: none">
            <img style="max-width:100%; max-height:400px;margin-bottom: 20px;" id="image_media_view"><br>
            <button type="button" class="btn btn-primary media-changer">Змінити</button>
        </div>

        <div class="form-group mb-3 video" style="display: none">
            <video style="max-width:100%; max-height:400px;margin-bottom: 20px;" controls id="video_media_view"></video>
            <br>
            <button type="button" class="btn btn-primary media-changer">Змінити</button>
        </div>

        <div class="form-group mb-3 audio " style="display: none">
            <audio style="max-width:100%; max-height:400px;margin-bottom: 20px;" controls id="audio_media_view"></audio>
            <br>
            <button type="button" class="btn btn-primary media-changer">Змінити</button>
        </div>

        <div class="form-group mb-3">
            <label for="body">Опис:</label>
            <textarea class="form-control" id="editor" name="body" required
            >{{old('body')?old('body'):(isset($body)?$body:'')}}</textarea>
        </div>

        <div class="form-group">
            <button style="cursor:pointer;" id="save_changes" type="submit" class="btn btn-primary">Зберегти</button>
        </div>
    </form>

    <input style="display: none;" type="file" name="file" id="file_input">

</div>

<script>
    function hideAllBlocks(media) {
        document.querySelector(".youtube").style.display = "none";
        document.querySelector(".video").style.display = "none";
        document.querySelector(".audio").style.display = "none";
        document.querySelector(".image").style.display = "none";
        document.querySelector("#image_media_view").src = "";
        document.querySelector("#video_media_view").src = "";
        document.querySelector("#youtube_media_view").src = "";
        document.querySelector("#audio_media_view").src = "";
        document.querySelector("." + media).style.display = "block";
    }

    function setInputFileAccepts(type) {
        if (type == "audio") return document.querySelector("#file_input").accept = "audio/mp3"
        if (type != "youtube") document.querySelector("#file_input").accept = type + "/*";
    }

    function onChangeMediaType() {
        document.querySelector("#file_input").value = "";
        hideAllBlocks(document.querySelector('#media_type').value);
        setInputFileAccepts(document.querySelector('#media_type').value);
    }

    document.querySelector("#media_type").addEventListener("change", () => {
        document.querySelector("#url").value = "";
        onChangeMediaType();
    });

    document.querySelector("#url").addEventListener("change", e => {
        let src = document.querySelector("#url").value;
        if (document.querySelector('#media_type').value == "youtube") {
            src = parseYoutubeUrl(src);
        } else {
            src = "{{Storage::url("")}}" + document.querySelector('#media_type').value + "s/" + src;
        }
        document.querySelector("#" + document.querySelector('#media_type').value + "_media_view").src = src;
    })

    onChangeMediaType();
    document.querySelector("#url").dispatchEvent(new Event("change", {
        bubbles: !0,
        cancelable: !1
    }));

    document.querySelectorAll(".media-changer").forEach(btn => btn.addEventListener("click", e => document.querySelector("#file_input").click()))

</script>
@include("layouts.footer")
