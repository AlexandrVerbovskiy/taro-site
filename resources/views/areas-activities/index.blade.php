
@include('layouts.main-header')
<h3 class="text-center title_margin activity-title" id="activity_title" style="margin: 110px 0 30px">123123123</h3>
<div class="container">
    <div class="row justify-content-center" style="width: 100%; margin: 0">
        <div class="col-lg-6 col-md-8 col-sm-8">
            <img src="{{Storage::url("/images/$activity->img_src")}}"
                 style="width: 100%; height: auto; margin-bottom: 15px">
        </div>
        <div style=" margin: 20px 0;">
            {!!$activity->body!!}
        </div>
    </div>
</div>
<script>
    {{--switch (localStorage.getItem('language')) {--}}
    {{--    case "ua":--}}
    {{--        document.getElementById('activity_title').innerHTML= `{{$activity->title_ua}}`;--}}
    {{--        break;--}}
    {{--    case "ru":--}}
    {{--        document.getElementById('activity_title').innerHTML= `{{$activity->title_ru}}`;--}}
    {{--        break;--}}
    {{--}--}}
    vocabulary['activity_title']= {
        ru: `{{$activity->title_ru}}`,
        ua: `{{$activity->title_ua}}`,
    }
    subscribeOnChangeLanguage('.activity-title', 'activity_title');

</script>
@include('layouts.footer')
