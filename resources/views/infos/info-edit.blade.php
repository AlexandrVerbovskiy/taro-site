@extends('layouts.admin')
@section('content')
<div class="container py-4">
    <h2 style="margin-bottom: 24px">Розділ корисної інформації</h2>
    <form class='form' method="POST" action="{{url('/admin/save-info')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="title_ua">Назва розділу(ua):</label>
            <input type="text" class="form-control" id="title_ua"
                   value="{{old('title_ua')?old('title_ua'):(isset($title_ua)?$title_ua:'')}}"
                   name="title_ua" required>
        </div>

        <div class="form-group mb-3">
            <label for="title_ru">Назва розділу(ru):</label>
            <input type="text" class="form-control" id="title_ru"
                   value="{{old('title_ru')?old('title_ru'):(isset($title_ru)?$title_ru:'')}}"
                   name="title_ru" required>
        </div>

        <div class="form-group">
            <button style="cursor:pointer; width: 100px" id="save_changes" type="submit" class="btn btn-primary">Зберегти</button>
        </div>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>
</div>
@stop
