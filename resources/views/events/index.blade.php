@include('layouts.header')
<div class="container">
    <div class="loader hidden"></div>
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
                       <div>
                        <div>Id: ${event["id"]}</div>
                        <div>Title: ${event["title"]}</div>
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
                        getNewEvents();
                    }
                }
            });
        });
    });

    getNewEvents();


</script>
