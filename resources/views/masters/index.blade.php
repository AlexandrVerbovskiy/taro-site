@include('layouts.main-header')
<div class="row" style="width: 100%; margin: 80px 0 0 0; ">
    <div class="col">
        <h4 style="margin: 20px 0" class="text-center">{{$master->last_name}} {{$master->first_name}}</h4>
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <div class="col-lg-3 col-md-6 col-sm-8">
        <img src="https://images.unsplash.com/photo-1675453442429-1ea5b9652743?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80"
             style="width: 100%; height: auto;">
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <h5 class="col text-center" style="margin: 20px 0">
        Астролог
    </h5>
</div>
<div>
    <div class="container">
        {!!$master->description!!}
    </div>
    <div class="container">
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
        Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
        Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
        Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
</div>
<div class="row justify-content-center" style="width: 100%; margin: 0">
    <div class="col text-center" style="margin: 20px 0">
        Відгуки
    </div>
    <div id="comments_list">

    </div>
    <div class="loader hidden"></div>
</div>
<textarea id="comment_inbox" row="10"></textarea><button class="btn btn-primary" id="send_comment">Send</button>
<script>
    const count = 20;
    let showed = 0;
    let canShow = true;
    let lastShownId = -1;

    const buildNewComment = (comment, typeInsert = 'beforeEnd') =>{
        const elem = `
           <div data-id=${comment["id"]}>
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
