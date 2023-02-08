@include('layouts.main-header')
<div class="container">
<h3 class="text-center title_margin" style="margin: 110px 0 30px">Навчання</h3>
@foreach($studies as $study)
    <div class="row justify-content-center" style="width: 100%; margin: 0;">
        <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 20px; padding: 20px; margin-bottom: 50px; height: auto;">
            <div class="d-flex flex-column">
                <div><h3>{{$study['title']}}</h3></div>
                <div style="margin: 0 0 40px 0;">{{$study['body']}}</div>
                <div class="d-flex justify-content-between align-items-end" style="bottom: 0;">
                    <label>Дата: {{explode(' ', $study['date'])[0]}}</label>
                    <a class="btn btn-light master_sec_button">Запис</a>
                </div>
            </div>
        </div>
    </div>
@endforeach
</div>
@include('layouts.footer')
