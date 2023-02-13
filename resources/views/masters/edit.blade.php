@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 style="margin-bottom: 24px">Майстер</h2>
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

        <div class="form-group mb-3">
            <label for="description">Опис:</label>
            <textarea class="form-control" id="editor" name="description" required
            >{{old('description')?old('description'):(isset($description)?$description:'')}}</textarea>
        </div>

        <input type="hidden"
               value="{{old('img_src')?old('img_src'):(isset($img_src)?$img_src:'')}}"
               name="img_src" required>
        <input accept="image/*" type="file" name="img" id="img_input">

        <div class="form-group" style="margin-top: 15px">
            <button style="cursor:pointer; width: 100px;" id="save_changes_fake" type="button" class="btn btn-primary">Зберегти</button>
            <button style="cursor:pointer; display: none;" id="save_changes" type="submit" class="btn btn-primary">Save</button>
        </div>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>




</div>
<script>

    $("#save_changes_fake").on("click", function () {
        if(document.querySelector("[name='img_src']").value){
            $("#save_changes").click();
        }else{
            alert("error");
        }
    })

</script>
@stop
