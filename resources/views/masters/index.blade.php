@include('layouts.main-header')
<div class="row" style="width: 100%; margin: 80px 0 0 0; " >
    <div class="col">
        <h4 style="margin: 20px 0" class="text-center">{{$master->last_name}} {{$master->first_name}}</h4>
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; height: auto; max-height: 450px; margin: 0">
    <div class="text-center col-lg-8" style="padding: 0; ">
        <img src="{{Storage::url("/images/$master->img_src")}}"
             style="width: 100%; height: inherit; max-height: 450px; object-fit: contain; /*margin-top: 80px*/">
    </div>

</div>

<div class="row justify-content-center" style="width: 100%; margin: 0">
</div>
<div>
    <div class="container" style="margin-top: 20px">
        {!!$master->description!!}
    </div>
</div>
<div class="container text-center">
    @if (!auth()->check())
        <a type="button" class="btn btn-primary button_for_valera master_login"
           href="{{url("/login")}}" data-bs-toggle="modal" data-bs-target="#login">Увійти</a>
    @else
        <button id="modal_open" data-bs-toggle="modal" data-bs-target="#enrol" style="display: none;"></button>
        <button type="button" class="btn btn-primary button_for_valera master_enrol" onclick="openModal()">Записатися</button>
    @endif

</div>
<h4 class="col text-center master_reviews" style="margin: 20px 0">
    Відгуки
</h4>
<div class="container">
    <textarea id="comment_inbox" row="10" style="width: 100%; border-radius: 10px; margin-bottom: -8px; padding: 10px;"
              placeholder="Залиште свій відгук" class="master_review_text"></textarea>
    <button class="btn btn-primary comment_button master_send_review" id="send_comment">Надіслати</button>
</div>
<div class="container">
    <div class="row justify-content-center" style="width: 100%; margin: 0">


        <div id="comments_list" style="padding: 0"></div>

        <div class="loader hidden"></div>

    </div>
</div>
<br>

@if(auth()->check())
<div class="modal fade" id="enrol" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true"
     style="backdrop-filter: blur(15px);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #a9c6ff; border-radius: 25px; border: 0; margin: 0 20px">
            <div class="modal-header d-flex justify-content-center"
                 style="border: 0; margin: 18px 0; padding-bottom: 0">
                <p style="display: inline" class="modal-title popup_master_enrol_title" id="exampleModalLongTitle">Запис
                    до</p><p style="display: inline;" class="modal-title">&nbsp{{$master->last_name}} {{$master->first_name}}</p>
            </div>
            <div class="modal-body padding_for_form">
                <div class="card-body" style="padding: 0; margin-top: -10px">
                    <div>
                        <p style="display: inline" class="popup_master_enrol_name">Запис на ім'я:</p><p style="display: inline">&nbsp<?=auth()->user()->first_name ?> <?=auth()->user()->last_name ?></p>
                        <p class="popup_master_enrol_text_one">Відслідковувати статус запису на відовідній сторінці, щоб потрапити на неї натисніть на меню
                            та оберіть її</p>
                        <p class="popup_master_enrol_text_two">Коли адміністратор розгляне ваш запис, то статус зміниться та вам зателефонують</p>
                    </div>
                    <div class="alert_css alert" role="alert" style="margin-bottom: 48px;"></div>
                    <button id="note_to_master" style="cursor:pointer; margin: -32px 0 0 0" type="button"
                            class="btn btn-primary form_main_button popup_master_enrol_submit">Записатися
                    </button>
                </div>
            </div>
        </div>
        <div id="comments_list">

        </div>
        <div class="loader hidden"></div>
    </div>
@endif

<script>
    const count = 20;
    let showed = 0;
    let canShow = true;
    let lastShownId = -1;

    const buildNewComment = (comment, typeInsert = 'beforeEnd') => {
        const elem = `
           <div data-id=${comment["id"]} style="background: #a9c6ff; border-radius: 15px; padding: 20px; margin: 20px 0">
            <div>${comment["id"]}</div>
            <div>${comment["body"]}</div>
        </div>`;
        console.log(typeInsert);
        document.querySelector("#comments_list").insertAdjacentHTML(typeInsert, elem);
    }

    function openModal(id){
        document.querySelector(".alert").innerHTML="";
        document.querySelector(".alert").classList.remove("alert-success");
        document.querySelector(".alert").classList.remove("alert-danger");
        document.querySelector("#modal_open").click();
    }

    const getNewComments = () => {
        document.querySelector(".loader").classList.remove('hidden');
        if (!canShow) return document.querySelector(".loader").classList.add('hidden');
        post("{{url('/get-master-comments')}}", {master_id: {{$master->id}}, start: showed, count: count}, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return canShow = false;
            if (data.comments.length != count) canShow = false;
            showed += data.comments.length;
            data.comments.forEach(comment => {
                buildNewComment(comment)
            });
        });
    }

    getNewComments();

    $(document).ready(function () {
        var windowHeight = $(window).height();
        $(document).on('scroll', function () {
            $('.loader').each(function () {
                var self = $(this),
                    height = self.offset().top + self.height();
                if ($(document).scrollTop() + windowHeight >= height) {
                    if (self.hasClass('hidden')) {
                        getNewComments();
                    }
                }
            });
        });
    });

    const comments = @json($comments);
    console.log(comments);
    comments.forEach((elem) => buildNewComment(elem));

    document.querySelector("#send_comment").addEventListener("click", () => {
        const value = document.querySelector("#comment_inbox").value;
        document.querySelector("#comment_inbox").innerHTML = "";
        document.querySelector("#comment_inbox").value = "";
        post("/create-master-comments", {master_id: {{$master->id}}, body: value}, res => {
            console.log(res)
            if (res.error) return alert(res.message)
            buildNewComment(res.comment, 'afterBegin')
        })
    })

    @if(auth()->check())
    document.querySelector("#note_to_master").addEventListener("click", e=>{
        post("{{"/note-to-master"}}", {master_id: {{$master->id}}}, res=> {
            const lang = getLang();
            let message = "";

            if (res.error) {
                document.querySelector(".alert").classList.remove("alert-success");
                document.querySelector(".alert").classList.add("alert-danger");
                if (!res.status) return;
                message = vocabulary['error_master_note'][res.status][lang];
            } else {
                document.querySelector(".alert").classList.add("alert-success");
                document.querySelector(".alert").classList.remove("alert-danger");
                message =vocabulary['success_master_note'][lang];
            }

            document.querySelector(".alert").innerHTML = message;
        }, true, true)
    })
    @endif
    if (document.querySelector('.master_login')) subscribeOnChangeLanguage('.master_login', 'master_login');
    if (document.querySelector('.master_enrol')) subscribeOnChangeLanguage('.master_enrol', 'master_enrol');
    subscribeOnChangeLanguage('.master_reviews', 'master_reviews');
    subscribeOnChangePlaceholderLanguage('.master_review_text', 'master_review_text');
    subscribeOnChangeLanguage('.master_send_review', 'master_send_review');
    if (document.querySelector('#enrol')) {
        subscribeOnChangeLanguage('.popup_master_enrol_title', 'popup_master_enrol_title');
        subscribeOnChangeLanguage('.popup_master_enrol_name', 'popup_master_enrol_name');
        subscribeOnChangeLanguage('.popup_master_enrol_text_one', 'popup_master_enrol_text_one');
        subscribeOnChangeLanguage('.popup_master_enrol_text_two', 'popup_master_enrol_text_two');
        subscribeOnChangeLanguage('.popup_master_enrol_submit', 'popup_master_enrol_submit');
    }
</script>
@include('layouts.footer')
