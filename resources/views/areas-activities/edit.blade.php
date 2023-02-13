@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 style="margin-bottom: 24px">Напрям діяльності</h2>
    <form class='form' method="POST" action="{{url('/admin/save-activity')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="title_ua">Заголовок напрямка(ua):</label>
            <input type="text" class="form-control" id="title_ua"
                   value="{{old('title_ua')?old('title_ua'):(isset($title_ua)?$title_ua:'')}}"
                   name="title_ua" required>
        </div>

        <div class="form-group mb-3">
            <label for="title_ru">Заголовок напрямка(ru):</label>
            <input type="text" class="form-control" id="title_ru"
                   value="{{old('title_ru')?old('title_ru'):(isset($title_ru)?$title_ru:'')}}"
                   name="title_ru" required>
        </div>

        <div class="form-group mb-3">
            <label for="title_ru">Тип:</label>
            <select id="type" name="type" required>
                <?php $saved_type = old('type') ? old('type') : (isset($type) ? $type : 'normal')?>
                @if($saved_type=='basic')
                    <option value="basic" selected>Основний</option>
                    <option value="additional">Додатковий</option>
                @else
                    <option value="basic">Основний</option>
                    <option value="additional" selected>Додатковий</option>
                @endif
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="body">Опис:</label>
            <textarea class="form-control" id="editor" name="body"
                      required>{{old('body')?old('body'):(isset($body)?$body:'')}}</textarea>

        </div>

        <input type="hidden" name="img_src"
               value="{{old('img_src')?old('img_src'):(isset($img_src)?$img_src:'')}}"
               required>
        <input accept="image/*" type="file" name="img" id="img_input">

        <div class="form-group" style="margin-top: 15px;">
            <button style="cursor:pointer; width: 100px;" id="save_changes_fake" type="button" class="btn btn-primary">Зберегти</button>
            <button style="cursor:pointer; display: none;" id="save_changes" type="submit" class="btn btn-primary">
                Save
            </button>
        </div>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>




</div>

<script>

    $(document).ready(function () {
        $('.form').keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
    });

    function setimage() {
        const input = $("#img_input");
        const fd = new FormData;

        fd.append('img', input.prop('files')[0]);

        fetch('{{url('/file-save')}}', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name=_token]').getAttribute('value')
            },
            method: 'POST',
            body: fd
        }).then(res => res.json()).then(data => {
            document.querySelector("[name='img_src']").value = data.filename;
        });
    }

    $("#save_changes_fake").on("click", function () {
        if (document.querySelector("[name='img_src']").value) {
            $("#save_changes").click();
        } else {
            alert("error");
        }
    })

</script>
@stop
