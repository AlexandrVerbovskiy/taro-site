@include('layouts.main-header')
<div class="container">
    <h3 class="text-center title_margin" style="margin: 80px 0 30px">Навчання</h3>
    <div class="loader hidden row justify-content-center" style="width: 100%; margin: 0;">

    </div>
</div>

<script>
    let showed = 0;
    const count = 20;
    const canShow = "{{$count}}";
    const topicId = "{{$topic_id}}"

    const getNewPosts = () => {
        console.log(showed, count)
        document.querySelector(".loader").classList.remove('hidden');
        if (showed >= canShow) return document.querySelector(".loader").remove();
        get("{{url('/get-studies')}}" + "?start=" + showed + "&count=" + count + "&topic=" + topicId, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return;
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
                                        <label>Дата: ${study["date"].split(' ')[0]}</label>
                                        <a class="btn btn-light master_sec_button">Запис</a>
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
