@extends('layouts.admin')
@section('content')
<div class="container py-4 message-parent">
    @include("layouts.error-message")
    <h2 style="margin-bottom: 24px; margin-top: 56px;">Майстер</h2>
    <form class='form' method="POST" action="{{url('/admin/save-master')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="first_name">Ім'я:</label>
            <input type="text" class="form-control" id="first_name"
                   value="{{old('first_name')?old('first_name'):(isset($first_name)?$first_name:'')}}"
                   name="first_name" required>
        </div>

        <div class="form-group mb-3">
            <label for="last_name">Прізвище:</label>
            <input type="text" class="form-control" id="last_name"
                   value="{{old('last_name')?old('last_name'):(isset($last_name)?$last_name:'')}}"
                   name="last_name" required>
        </div>


        <div class="form-group mb-3 image">
            <img style="max-width:100%; max-height:400px;" id="image_media_view"><br>
            <button type="button" class="btn btn-primary media-changer" style="margin-top: 10px">Змінити</button>
        </div>

        <input type="hidden"
               id="img_src"
               value="{{old('img_src')?old('img_src'):(isset($img_src)?$img_src:'')}}"
               name="img_src" required>

        <div class="form-group mb-3">
            <label for="description">Опис:</label>
            <textarea class="form-control" id="editor" name="description" required
            >{{old('description')?old('description'):(isset($description)?$description:'')}}</textarea>
        </div>

        <div class="form-group">
            <button style="cursor:pointer; width: 100px;" id="save_changes_fake" type="button" class="btn btn-primary">Зберегти</button>
            <button style="cursor:pointer; display: none;" id="save_changes" type="submit" class="btn btn-primary">Зберегти</button>
        </div>
    </form>

    <input style="display: none;" accept="image/*" type="file" name="img" id="img_input">

</div>
<script>

    $("#save_changes_fake").on("click", function () {
        if(document.querySelector("[name='img_src']").value){
            $("#save_changes").click();
        }else{
            alert("error");
        }
    })

    document.querySelector("#img_src").addEventListener("change", e => {
        let src = document.querySelector("#img_src").value;
        document.querySelector("#image_media_view").src = "{{Storage::url("")}}images/"+src;
    })

    document.querySelector("#img_src").dispatchEvent(new Event("change", {
        bubbles: !0,
        cancelable: !1
    }));

    document.querySelector(".media-changer").addEventListener("click", e=>document.querySelector("#img_input").click());

</script>
@stop
