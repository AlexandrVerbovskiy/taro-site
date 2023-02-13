@include('layouts.main-header')
<div class="row" style="width: 100%; margin: 80px 0 0 0; ">
    <div class="col">
        <h4 style="margin: 20px 0" class="text-center">{{$master->last_name}} {{$master->first_name}}</h4>
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <div class="col-lg-3 col-md-6 col-sm-8">
        <img src="{{Storage::url("/images/$master->img_src")}}"
             style="width: 100%; height: auto; margin-bottom: 30px">
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
</div>
<div>
    <div class="container">
        {!!$master->description!!}
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <div class="col text-center" style="margin: 20px 0">
        Відгуки
    </div>
</div>
@include('layouts.footer')
