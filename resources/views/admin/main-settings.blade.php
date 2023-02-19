@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 style="margin-top: 56px">Головна сторінка</h2>
    <form class='form' method="POST" action="{{url('/admin/save-main')}}">
        {{ csrf_field() }}

        <div class="form-group mb-3 image">
            <img style="max-width:100%; max-height:400px;" id="image_media_view"><br>
            <button style="margin-top: 10px" type="button" class="btn btn-primary media-changer">Змінити</button>
        </div>

        <input type="hidden"
               id="img_src"
               value="{{old('main_img')?old('main_img'):(isset($main_img)?$main_img:'')}}"
               name="main_img" required>

        <div class="form-group mb-3">
            <label for="description">Опис:</label>
            <textarea class="form-control" id="editor" name="main_body" required
            >{{old('main_body')?old('main_body'):(isset($main_body)?$main_body:'')}}</textarea>
        </div>

        <div class="form-group">
            <button style="cursor:pointer;" id="save_changes" type="submit" class="btn btn-primary">Зберегти</button>
        </div>
    </form>

    <input style="display: none;" accept="image/*" type="file" name="img" id="img_input">
</div>

<script>
    document.querySelector("#img_src").addEventListener("change", e => {
        let src = document.querySelector("#img_src").value;
        console.log(src);
        document.querySelector("#image_media_view").src = "{{Storage::url("")}}images/"+src;
    })

    document.querySelector("#img_src").dispatchEvent(new Event("change", {
        bubbles: !0,
        cancelable: !1
    }));

    document.querySelector(".media-changer").addEventListener("click", e=>document.querySelector("#img_input").click());
</script>

@stop
