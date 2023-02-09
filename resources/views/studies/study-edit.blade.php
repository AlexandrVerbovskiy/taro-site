@include('layouts.header')
<div class="container py-4">
    <h2>Topic</h2>
    <form class='form' method="POST" action="{{url('/admin/edit-study')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title"
                   value="{{old('title')?old('title'):(isset($title)?$title:'')}}"
                   name="title" required>
        </div>

        <div class="form-group mb-3">
            <label for="date">Date:</label>
            <input type="datetime-local" class="form-control" id="date"
                   value="{{old('date')?old('date'):(isset($date)?$date:'')}}"
                   name="date" required>
        </div>

        <div class="form-group mb-3">
            <label for="topic_id">Topic: </label>
            <select name="topic_id" id="topic_id">
                <?php foreach ($studies as $study) :
                    $saved_id=old('topic_id')?old('topic_id'):(isset($topic_id)?$topic_id:'-1')?>
                    @if($saved_id==$study->id)
                        <option value="{{$study->id}}" selected>{{$study->title_ua}}</option>
                    @else
                        <option value="{{$study->id}}">{{$study->title_ua}}</option>
                    @endif
                    <!--<option value="{{$study->id}}">{{$study->title_ru}}</option>-->
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="body">Description:</label>
            <textarea class="form-control" id="body" name="body" required
            >{{old('body')?old('body'):(isset($body)?$body:'')}}</textarea>
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
