@include('layouts.header')
<div class="container">
    <div class="loader hidden"></div>
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
                       <div>
                        <div>Id: ${study["id"]}</div>
                        <div>Title: ${study["title"]}</div>
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
