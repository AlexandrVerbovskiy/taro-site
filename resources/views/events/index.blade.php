@include('layouts.main-header')
<div class="container">
    <h3 class="text-center title_margin" style="margin: 110px 0 30px">ТОПИК</h3>
    <div class="loader hidden">

    </div>
</div>

<script>
    let showed = 0;
    const count = 20;
    let canShow = {{$count}}>0;
    const topicId = "{{$topic_id}}"

    const getNewEvents = () => {
        console.log(showed, count)
        document.querySelector(".loader").classList.remove('hidden');
        if (!canShow) return document.querySelector(".loader").remove();
        get("{{url('/get-events')}}" + "?start=" + showed + "&count=" + count + "&topic=" + topicId, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return canShow = false;
            let rows = "";
            showed += data.events.length;

            if(data.events.length != count) canShow = false;

            data.events.forEach(event =>
                rows += `
<div class="row justify-content-center" style="width: 100%; margin: 0;">
    <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 20px; padding: 20px; margin-bottom: 50px; height: auto;">
        <div class="d-flex flex-column">
            <div><h3>${event["title"]}</h3></div>
            <div style="margin: 0 0 40px 0;">${event["id"]}</div>
            <div class="d-flex justify-content-between align-items-end" style="bottom: 0;">
            </div>
        </div>
    </div>
</div>
                       `
            )
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
                        getNewEvents();
                    }
                }
            });
        });
    });

    getNewEvents();


</script>
@include('layouts.footer')
