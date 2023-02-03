@include('layouts.main-header')
<br><br>
<h3 class="text-center">Майстри</h3>
<div class="container">
    @foreach($masters as $master)
    <div class="row justify-content-center" style="width: 100%">
            <div class="master col-lg-9 col-md-12">
                <div class="d-flex flex-row align-items-start">
                    <div style="width: 170px; height: 100%; margin-right: 20px;">
                        <img class="master-image" src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/85/Smiley.svg/1200px-Smiley.svg.png">
                    </div>
                    <div>
                        <div class="d-flex flex-column">
                            <div>
                                <h4>{{$master['last_name']}} {{$master['first_name']}}</h4>
                                {{$master['description']}}
                            </div>
                            <div class="d-flex flex-row align-items-end" style="margin-top: 30px;">
                                <button type="button" class="btn btn-light" style="margin-right: 20px;">Запис до текст</button>
                                <a class="btn btn-light" href="/master/{{$master['id']}}}">Більше про майстра</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endforeach

</div>
@include('layouts.footer')
