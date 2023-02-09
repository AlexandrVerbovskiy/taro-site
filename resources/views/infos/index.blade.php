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
        get("{{url('/get-infos-posts')}}" + "?start=" + showed + "&count=" + count + "&topic=" + topicId, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return;
            let rows = "";
            showed += data.posts.length;
            data.posts.forEach(post =>
                rows += `
                       <div>
                        <div>Id: ${post["id"]}</div>
                        <div>Title: ${post["title"]}</div>
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
