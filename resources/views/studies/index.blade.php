@include('layouts.main-header')
<div class="container">
    <h3 class="text-center title_margin" style="margin: 110px 0 30px">Навчання</h3>
    <div class="loader hidden row justify-content-center" style="width: 100%; margin: 0;">

    </div>
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
</div>

<script>
    let showed = 0;
    const count = 20;
    let canShow = {{$count}}>0;
    const topicId = "{{$topic_id}}"

    const getNewPosts = () => {
        console.log(showed, count)
        document.querySelector(".loader").classList.remove('hidden');
        if (!canShow) return document.querySelector(".loader").remove();
        get("{{url('/get-studies')}}" + "?start=" + showed + "&count=" + count + "&topic=" + topicId, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return canShow = false;
            if(data.studies.length != count) canShow = false;

            let rows = "";
            showed += data.studies.length;
            data.studies.forEach(study =>
                rows += `
                       <div class="row justify-content-center" style="width: 100%; margin: 0;">
                            <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 20px; padding: 20px; margin-bottom: 50px; height: auto;">
                                <div class="d-flex flex-column">
                                    <div><h3>${study["title"]}</h3></div>
                                    <div style="margin: 0 0 40px 0;">${study["body"]}</div>
                                    <div class="d-flex justify-content-between align-items-end" style="bottom: 0;">
                                        <label class="date_study">Дата: ${study["date"].split(' ')[0]}</label>
                                        <a class="btn btn-light master_sec_button" data-bs-toggle="modal" data-bs-target="#enrol">Запис</a>
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


</script>

@include('layouts.footer')
