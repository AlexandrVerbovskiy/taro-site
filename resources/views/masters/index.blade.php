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
