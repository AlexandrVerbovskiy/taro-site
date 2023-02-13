@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 style="margin-bottom: 24px">Пост(корисна інформація)</h2>
    <div class="scroll_form">
        <form class='form' method="POST" action="{{url('/admin/save-info-post')}}">
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
                <label for="info_id">Розділ: </label>
                <select name="info_id" id="info_id">
                    <?php foreach ($infos as $info) :
                        $saved_id = old('info_id') ? old('info_id') : (isset($info_id) ? $info_id : '-1')?>
                    @if($saved_id==$info->id)
                        <option value="{{$info->id}}" selected>{{$info->title_ua}}</option>
                    @else
                        <option value="{{$info->id}}">{{$info->title_ua}}</option>
                    @endif
                    <!--<option value="{{$info->id}}">{{$info->title_ru}}</option>-->
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="form-group mb-3">
                <label for="media_type">Тип медіа: </label>
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

            <div class="form-group mb-3 youtube" style="display: none">
                <label for="url">Url:</label>
                <input type="text" placeholder="Укажіть посилання на ютуб" class="form-control" id="url"
                       value="{{old('url')?old('url'):(isset($url)?$url:'')}}"
                       name="url" required>
                <iframe id="youtube_media_view" class="youtube_media" style=""></iframe>
            </div>

            <div class="form-group mb-3 image" style="display: none">
                <img style="max-width:100%; max-height:400px; margin-bottom: 20px" id="image_media_view"><br>
                <button type="button" class="btn btn-primary media-changer">Додати файл</button>
            </div>

            <div class="form-group mb-3 video" style="display: none">
                <video style="max-width:100%; max-height:400px; margin-bottom: 20px" controls id="video_media_view"></video><br>
                <button type="button" class="btn btn-primary media-changer">Додати файл</button>
            </div>

            <div class="form-group mb-3 audio " style="display: none">
                <audio style="max-width:100%; max-height:400px; margin-bottom: 20px" controls id="audio_media_view"></audio><br>
                <button type="button" class="btn btn-primary media-changer">Додати файл</button>
            </div>

            <div class="form-group mb-3">
                <label for="body">Опис:</label>
                <textarea class="form-control" id="editor" name="body" required
                >{{old('body')?old('body'):(isset($body)?$body:'')}}</textarea>
            </div>

            <div class="form-group">
                <button style="cursor:pointer;" id="save_changes" type="submit" class="btn btn-primary">Зберегти</button>
            </div>

            @if($errors->any())
                <h4>{{$errors->first()}}</h4>
            @endif
        </form>

        <input style="display: none;" type="file" name="file" id="file_input">
    </div>


</div>

<script>
    function hideAllBlocks(media) {
        document.querySelector(".youtube").style.display = "none";
        document.querySelector(".video").style.display = "none";
        document.querySelector(".audio").style.display = "none";
        document.querySelector(".image").style.display = "none";
        document.querySelector("#image_media_view").src="";
        document.querySelector("#video_media_view").src="";
        document.querySelector("#youtube_media_view").src="";
        document.querySelector("#audio_media_view").src="";
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
        if(document.querySelector('#media_type').value=="youtube"){
            src = parseYoutubeUrl(src);
        }else{
            src = "{{Storage::url("")}}"+document.querySelector('#media_type').value+"s/"+src;
        }
       document.querySelector("#" + document.querySelector('#media_type').value + "_media_view").src = src;
    })

    onChangeMediaType();
    document.querySelector("#url").dispatchEvent(new Event("change", {
        bubbles: !0,
        cancelable: !1
    }));

    document.querySelectorAll(".media-changer").forEach(btn=>btn.addEventListener("click", e=>document.querySelector("#file_input").click()))
</script>
@stop
