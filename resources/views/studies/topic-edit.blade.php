@include('layouts.header')
<div class="container py-4">
    <h2>Topic</h2>
    <form class='form' method="POST" action="{{url('/create-study-topic')}}">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="title_ua">Name(ua):</label>
            <input type="text" class="form-control" id="title_ua" name="title_ua" required>
        </div>

        <div class="form-group mb-3">
            <label for="title_ru">Name(ru):</label>
            <input type="text" class="form-control" id="title_ru" name="title_ru" required>
        </div>

        <div class="form-group">
            <button style="cursor:pointer;" id="save_changes" type="submit" class="btn btn-primary">Save</button>
        </div>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>
</div>
@include('layouts.footer')
