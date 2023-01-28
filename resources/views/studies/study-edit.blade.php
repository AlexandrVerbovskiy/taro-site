@include('layouts.header')
<div class="container py-4">
    <h2>Topic</h2>
    <form class='form' method="POST" action="{{url('/create-study')}}">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="form-group mb-3">
            <label for="date">Date:</label>
            <input type="datetime-local" class="form-control" id="date" name="date" required>
        </div>

        <div class="form-group mb-3">
            <label for="topic_id">Topic:</label>
            <select name="topic_id" id="topic_id">
                <?php foreach ($studies as $study) : ?>
                    <option value="{{$study->id}}">{{$study->title_ua}}</option>
                    <!--<option value="{{$study->id}}">{{$study->title_ru}}</option>-->
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="body">Description:</label>
            <textarea class="form-control" id="body" name="body" required> </textarea>
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
