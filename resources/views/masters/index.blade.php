@include('layouts.main-header')
<br>
<div class="row" style="width: 100%">
    <div class="col">
        <h3 class="text-center">{{$master->last_name}} {{$master->first_name}}</h3>
    </div>
</div>
<div class="row justify-content-center" style="width: 100%">
    <div class="col-lg-3 col-md-6 col-sm-8">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Smiley.svg/1200px-Smiley.svg.png"
             style="width: 100%; height: auto;">
    </div>
</div>
<div class="row justify-content-center" style="width: 100%">
    <div class="col text-center">
        {{$master->description}}
    </div>
</div>

@include('layouts.footer')
