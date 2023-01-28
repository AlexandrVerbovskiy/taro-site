<div>
    <h2>First name: {{$master->first_name}}</h2>
    <h2>Last name: {{$master->last_name}}</h2>
    <div>
        {{$master->description}}
    </div>
    <img src="{{asset('storage/images/'.$master->img_src)}}">
</div>
