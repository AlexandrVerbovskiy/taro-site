@include('layouts.main-header')
<div class="container">
    <h3 class="text-center title_margin studies_title" style="margin: 110px 0 30px">Навчання</h3>
    <div class="loader hidden row justify-content-center" style="width: 100%; margin: 0;">

    </div>
</div>

@if (auth()->check())
<div class="modal fade" id="enrol" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true"
     style="backdrop-filter: blur(15px);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #a9c6ff; border-radius: 25px; border: 0; margin: 0 20px">
            <div class="modal-header d-flex justify-content-center"
                 style="border: 0; margin: 18px 0; padding-bottom: 0">
                <p class="modal-title popup_studies_title" id="exampleModalLongTitle" style="/*font-size: 30px;*/">Запис на навчання</p>
            </div>
            <div class="modal-body padding_for_form">
                <div class="card-body" style="padding: 0; margin-top: -10px">
                    <div>
                        <p class="popup_studies_name" style="display: inline">Запис на ім'я:</p><p style="display: inline;">&nbsp<?=auth()->user()->first_name ?> <?=auth()->user()->last_name ?></p>
                        <p class="popup_studies_text_one">Відслідковувати статус запису на відовідній сторінці, щоб потрапити на неї натисніть на меню
                            та оберіть її</p>
                        <p class="popup_studies_text_two">Коли адміністратор розгляне ваш запис, то статус зміниться та вам зателефонують</p>
                    </div>
                    <div class="alert" role="alert" onload="alert(123);"></div>

                    <button id="note_to_study" style="cursor:pointer; margin: 0 0 -16px 0" type="button"
                            class="btn btn-primary form_main_button popup_studies_send_button">Відправити
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>


<a id="modal_open" class="btn btn-light master_sec_button" data-bs-toggle="modal" data-bs-target="#enrol" style="display:none;"></a>
@endif

<script>
    let showed = 0;
    const count = 20;
    let canShow = {{$count}} > 0;
    const topicId = "{{$topic_id}}"

    const getNewPosts = () => {
        console.log(showed, count)
        document.querySelector(".loader").classList.remove('hidden');
        if (!canShow) return document.querySelector(".loader").remove();
        get("{{url('/get-studies')}}" + "?start=" + showed + "&count=" + count + "&topic=" + topicId, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return canShow = false;
            if (data.studies.length != count) canShow = false;

            let rows = "";
            showed += data.studies.length;
            data.studies.forEach(study =>
                rows += `
                       <div class="row justify-content-center study" style="width: 100%; margin: 0;" onload="load();">
                            <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 20px; padding: 20px; margin-bottom: 50px; height: auto;">
                                <div class="d-flex flex-column">
                                    <div><h3>${study["title"]}</h3></div>
                                    <div style="margin: 0 0 40px 0;">${study["body"]}</div>
                                    <div class="d-flex justify-content-between align-items-end" style="bottom: 0;">
                                        <label class="date_study">Дата: ${study["date"].split(' ')[0]}</label>
                                        @if (auth()->check())
                                            <a class="btn btn-light master_sec_button" onload="load()" onclick="openModal(${study["id"]})">Запис</a>
                                        @else
                                            <a type="button" class="btn btn-light master_sec_button" href="{{url("/login")}}"  data-bs-toggle="modal" data-bs-target="#login">Увійти</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                    </div>`)
            document.querySelector(".loader").insertAdjacentHTML('beforebegin', rows);
        });
    }

    $(document).ready(function () {
        var windowHeight = $(window).height();
        $(document).on('scroll', function () {
            $('.loader').each(function () {
                var self = $(this),
                    height = self.offset().top + self.height();
                if ($(document).scrollTop() + windowHeight >= height) {
                    if (self.hasClass('hidden')) {
                        getNewPosts();
                    }
                }
            });
        });
    });

    getNewPosts();

    function openModal(id){
        document.querySelector(".alert").innerHTML="";
        document.querySelector(".alert").classList.remove("alert-success");
        document.querySelector(".alert").classList.remove("alert-danger");
        document.querySelector("#note_to_study").dataset.id = id;
        document.querySelector("#modal_open").click();
    }

    @if (auth()->check())
    document.querySelector("#note_to_study").addEventListener("click", e => {
        const study_id = e.target.dataset.id
        post("{{"/note-to-study"}}", {study_id}, res => {
            if(res.error){
                document.querySelector(".alert").classList.remove("alert-success");
                document.querySelector(".alert").classList.add("alert-danger");
            }else{
                document.querySelector(".alert").classList.add("alert-success");
                document.querySelector(".alert").classList.remove("alert-danger");
            }
            document.querySelector(".alert").innerHTML=res.message;
        })
    })
    @endif

    subscribeOnChangeLanguage(".studies_title", "studies_title");
    if (document.querySelector(".popup_studies_name")) subscribeOnChangeLanguage(".popup_studies_name", "popup_studies_name");
    if (document.querySelector(".popup_studies_title")) {
        subscribeOnChangeLanguage(".popup_studies_title", "popup_studies_title");
        subscribeOnChangeLanguage(".popup_studies_text_one", "popup_studies_text_one");
        subscribeOnChangeLanguage(".popup_studies_text_two", "popup_studies_text_two");
        subscribeOnChangeLanguage(".popup_studies_send_button", "popup_studies_send_button");
    }
</script>

@include('layouts.footer')
