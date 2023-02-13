@include('layouts.main-header')
<div class="row" style="width: 100%; margin: 80px 0 0 0; ">
    <div class="col">
        <h4 style="margin: 20px 0" class="text-center">{{$master->last_name}} {{$master->first_name}}</h4>
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <div class="col-lg-3 col-md-6 col-sm-8">
        <img src="https://images.unsplash.com/photo-1675453442429-1ea5b9652743?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80"
             style="width: 100%; height: auto;">
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <h5 class="col text-center" style="margin: 20px 0">
        Астролог
    </h5>
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
