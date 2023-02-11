<div>
    <h2>RU: {{$activity->title_ru}}</h2>
    <h2>UA: {{$activity->title_ua}}</h2>
    <div>
        {!!$activity->body!!}
    </div>
    <img src="{{asset('storage/images/'.$activity->img_src)}}">
</div>
