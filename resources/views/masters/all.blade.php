@include('layouts.main-header')
<h3 class="text-center title_margin" style="margin: 80px 0 30px">Майстри</h3>
<!--@foreach($masters as $master)
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
    @endforeach-->
    <div class="container">
        @foreach($masters as $master)
            <div class="row justify-content-center" style=" margin: 0 20px;">
                <div class="masterSaniaZaebalEdition col-lg-9 col-md-12">
                    <div class="row">
                        <div class="col-md-auto">
                            <div style="">
                                <img class="master-imageSaniaZaebalEdition"
                                     src="https://images.unsplash.com/photo-1675453442429-1ea5b9652743?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80">
                            </div>
                        </div>
                        <div class="col col-lg-8">
                            <div class="masterDescHeight" style="">
                                <p class="master_nameSaniaZaebalEdition">{{$master['last_name']}} {{$master['first_name']}}</p>
                                <div class="master_descriptionSaniaZaebalEdition" style="">
                                    <!-- Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque non faucibus dui, eget malesuada est. Aliquam risus ligula, molestie vel risus ac, euismod ultrices orci. Praesent finibus libero vitae magna congue interdum. asdasdsadasdasdasdasdasdasdadss -->
                                    {{$master['description']}}
                                </div>
                            </div>
                            <div class="align-items-end" style="padding: 0 0px; bottom: 0; ">
                                <a class="btn btn-light master_sec_buttonSaniaZaebalEdition" href="/master/{{$master['id']}}}">Більше про майстра</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="row justify-content-center" style="width: 100%; margin: 0;">
            <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 20px; padding: 20px; margin-bottom: 50px; height: 160px;">
                <div class="d-flex flex-column">
                    <div style="margin: 0 0 40px 0;"><h3>Заголовок події</h3></div>
                    <div class="d-flex justify-content-between align-items-end" style="bottom: 0;">
                        <label>Дата: 19.10.2002</label>
                        <a class="btn btn-light master_sec_button">Детальніше</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center" style="width: 100%; margin: 0;">
            <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 20px; padding: 20px; margin-bottom: 50px; height: auto;">
                <div class="d-flex flex-column">
                    <div><h3>Заголовок навчання</h3></div>
                    <div style="margin: 0 0 40px 0;">Lorem ipsum dol ut nulla nulla. Mauris dapibus tristiqueLorem ipsum dolor sit amet, consectetur adipiscing elit. Nam ut nulla nulla. Mauris dapibus tristique</div>
                    <div class="d-flex justify-content-between align-items-end" style="bottom: 0;">
                        <label>Дата: 19.10.2002</label>
                        <a class="btn btn-light master_sec_button">Запис</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
