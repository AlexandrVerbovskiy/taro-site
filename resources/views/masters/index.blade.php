@include('layouts.main-header')
<div class="row" style="width: 100%; margin: 80px 0 0 0; ">
    <div class="col">
        <h4 style="margin: 20px 0" class="text-center">{{$master->last_name}} {{$master->first_name}}</h4>
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <div class="col-lg-3 col-md-6 col-sm-8">
        <img src="{{Storage::url("/images/$master->img_src")}}"
             style="width: 100%; height: auto; margin-bottom: 30px">
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
</div>
<div>
    <div class="container">
        {!!$master->description!!}
    </div>
</div>
<div class="container text-center">
    @if (!auth()->check())
        <a type="button" class="btn btn-primary button_for_valera @if(Request::segment(1) == 'login') active @endif" href="{{url("/login")}}"
           type="submit" data-bs-toggle="modal" data-bs-target="#login">Увійти</a>
        <div class="d-flex flex-column">
            <div style="font-size: 12px; margin: 20px 0 60px">
                Зайти в акаунт сначала блять а потом заказывай свои наебки
            </div>
        </div>

    @else
        <button type="button" class="btn btn-primary button_for_valera" data-bs-toggle="modal" data-bs-target="#enrol">Записатися</button>
    @endif

</div>
<div class="container">
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <h4 class="col text-center" style="margin: 20px 0">
        Відгуки
    </h4>

        <div id="comments_list" style="padding: 0"></div>

        <div class="loader hidden"></div>

</div>
</div>
<div class="container">
    <textarea id="comment_inbox" row="10" style="width: 100%; border-radius: 10px; margin-bottom: -8px; padding: 10px;" placeholder="Залиште свій відгук"></textarea>
    <button class="btn btn-primary comment_button" id="send_comment">Надіслати</button>
</div>

<div class="modal fade" id="enrol" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true"
     style="backdrop-filter: blur(15px);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #a9c6ff; border-radius: 25px; border: 0; margin: 0 20px">
            <div class="modal-header d-flex justify-content-center"
                 style="border: 0; margin: 18px 0; padding-bottom: 0">
                <p class="modal-title" id="exampleModalLongTitle" style="/*font-size: 30px;*/"><?=auth()->user()->first_name ?></p>
            </div>
            <div class="modal-body padding_for_form">
                <div class="card-body" style="padding: 0; margin-top: -10px">
                    <div>
                        <p class="text-center" style="font-size: 14px">На вказану вами пошту прийде лист для скидання
                            паролю. Якщо ви не побачите листа, то перевірте будь-ласка спам.</p>
                    </div>
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form action="{{ url('forget-password') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <button style="cursor:pointer; margin: 0 0 -16px 0" type="submit"
                                    class="btn btn-primary form_main_button">Відправити
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="comments_list">

    </div>
    <div class="loader hidden"></div>
</div>

<script>
    const count = 20;
    let showed = 0;
    let canShow = true;
    let lastShownId = -1;

    const buildNewComment = (comment, typeInsert = 'beforeEnd') =>{
        const elem = `
           <div data-id=${comment["id"]} style="background: #a9c6ff; border-radius: 15px; padding: 20px; margin: 20px 0">
            <div>${comment["id"]}</div>
            <div>${comment["body"]}</div>
        </div>`;
        console.log(typeInsert);
        document.querySelector("#comments_list").insertAdjacentHTML(typeInsert, elem);
    }

    const getNewComments = () => {
        document.querySelector(".loader").classList.remove('hidden');
        if (!canShow) return document.querySelector(".loader").classList.add('hidden');
        post("{{url('/get-master-comments')}}",{master_id:{{$master->id}}, start:showed, count: count}, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return canShow = false;
            if(data.comments.length != count) canShow = false;
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
    comments.forEach((elem)=>buildNewComment(elem));

    document.querySelector("#send_comment").addEventListener("click", ()=>{
        const value = document.querySelector("#comment_inbox").value;
        console.log(value);
        document.querySelector("#comment_inbox").innerHTML = "";
        post("/create-master-comments", {master_id: {{$master->id}}, body: value}, res=>{
            console.log(res)
            if(res.error) return alert(res.message)
            buildNewComment(res.comment, 'afterBegin')
        })
    })
</script>
@include('layouts.footer')
