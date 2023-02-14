@extends('layouts.admin')
@section('content')
    <script>
        post('{{url('/admin/get-comments')}}', {search: '', count: 10, start: 0}, res => {
            console.log(res)
        });
    </script>
@stop
