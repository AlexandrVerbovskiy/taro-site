@include('layouts.main-header')
<h3 class="text-center title_margin" style="margin: 110px 0 30px">Майстри</h3>
<div class="container">
    @foreach($masters as $master)
    <div class="row justify-content-center" style="width: 100%; margin: 0;">
            <div class="master col-lg-9 col-md-12">
                <div class="d-flex flex-row align-items-start">
                    <div style="width: 160px; height: 200px;  margin: 0 20px 0 0;">
                        <img class="master-image" style=""
                             src="https://images.unsplash.com/photo-1675453442429-1ea5b9652743?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80">
                    </div>
                    <div class="d-flex flex-column master_sec_div">
                        <div style="height: 100%">
                            <p class="master_name">{{$master['last_name']}} {{$master['first_name']}}</p>
                            <div class="master_description">
                                {{$master['description']}}
                            </div>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 align-items-end" style="padding: 0 12px; bottom: 0">
                            <button type="button" class="btn btn-light master_sec_button" style="margin-right: 20px">Запис до {{$master['first_name']}}</button>
                            <a class="btn btn-light master_sec_button" href="/master/{{$master['id']}}}">Більше про майстра</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    @endforeach

</div>
@include('layouts.footer')
