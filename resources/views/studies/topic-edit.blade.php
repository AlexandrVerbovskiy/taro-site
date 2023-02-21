@extends('layouts.admin')
@section('content')
<div class="container py-4 message-parent">
    @include("layouts.error-message")
    <h2 style="margin-bottom: 24px; margin-top: 56px">Категорія навчення</h2>
    <form class='form' method="POST" action="{{url('/admin/save-study-topic')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="title_ua">Назва(ua):</label>
            <input type="text" class="form-control" id="title_ua"
                   value="{{old('title_ua')?old('title_ua'):(isset($title_ua)?$title_ua:'')}}"
                   name="title_ua" required>
        </div>

        <div class="form-group mb-3">
            <label for="title_ru">Назва(ru):</label>
            <input type="text" class="form-control" id="title_ru"
                   value="{{old('title_ru')?old('title_ru'):(isset($title_ru)?$title_ru:'')}}"
                   name="title_ru" required>
        </div>

        <div class="form-group">
            <button style="cursor:pointer;" id="save_changes" type="submit" class="btn btn-primary">Зберегти</button>
        </div>
    </form>
</div>
@include("layouts.footer")
