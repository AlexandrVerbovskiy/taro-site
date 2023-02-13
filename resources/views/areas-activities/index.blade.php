
@include('layouts.main-header')
<h3 class="text-center title_margin" style="margin: 110px 0 30px">{{$activity->title_ua}}</h3>
<div class="container">
    <div class="row justify-content-center" style="width: 100%; margin: 0">
        <div class="col-lg-3 col-md-6 col-sm-8">
            <img src="{{Storage::url("/images/$activity->img_src")}}"
                 style="width: 100%; height: auto;">
        </div>
        <div style=" margin: 20px 0;">
            {!!$activity->body!!}
        </div>
    </div>
</div>
@include('layouts.footer')
