
@include('layouts.main-header')
<h3 class="text-center title_margin" style="margin: 80px 0 30px">{{$activity->title_ua}}</h3>
<div class="container">
    <div class="row justify-content-center" style="width: 100%; margin: 0">
        <div class="col-lg-3 col-md-6 col-sm-8">
            <img src="https://images.unsplash.com/photo-1675453442429-1ea5b9652743?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80"
                 style="width: 100%; height: auto;">
        </div>
        <div>
            {{$activity->body}}
        </div>
    </div>
</div>
@include('layouts.footer')
