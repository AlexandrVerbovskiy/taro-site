@include('layouts.main-header')
<div class="container">
    <h3 class="text-center title_margin" style="margin: 110px 0 30px">Корисна инфо посты</h3>
    <div class="loader hidden">

    </div>
</div>

@include('layouts.footer')
<script>
    let showed = 0;
    const count = 20;
    let canShow = {{$count}}>0;
    const topicId = "{{$topic_id}}"

    const getNewPosts = () => {
        console.log(showed, count)
        document.querySelector(".loader").classList.remove('hidden');
        if (!canShow) return document.querySelector(".loader").remove();
        get("{{url('/get-infos-posts')}}" + "?start=" + showed + "&count=" + count + "&topic=" + topicId, data => {
            document.querySelector(".loader").classList.add('hidden');
            if (data.error) return canShow = false;
            if(data.posts.length != count) canShow = false;
            let rows = "";
            showed += data.posts.length;
            data.posts.forEach((post) => {
                let mediaContent;
                switch(post["media_type"]) {
                    case "youtube":
                        mediaContent = `<iframe id="youtube_media_view" class="youtube_media" style="" src="${parseYoutubeUrl(post['url'])}"></iframe>`
                        break;
                    case "audio":
                        mediaContent = `<audio style="max-width:100%; max-height:400px; margin-bottom: 20px" controls="" id="audio_media_view" src="/storage/${post['url']}"></audio>`
                        break;
                    case "video":
                        mediaContent = `<video style="max-width:100%; max-height:400px; margin-bottom: 20px" controls="" id="video_media_view" src="/storage/videos/${post['url']}"></video`;
                        break;
                    case "image":
                        mediaContent=`<img style="max-width:100%; max-height:400px; margin-bottom: 20px" id="image_media_view" src="/storage/images/${post['url']}">`;
                        break;
                }
                rows += `
<div class="row justify-content-center" style="width: 100%; margin: 0;">
    <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 20px; padding: 20px; margin-bottom: 50px; height: auto;">
        <div class="d-flex flex-column">
            <div><h3>${post["title"]}</h3></div>
            <div>${post["body"]}</div>
            <div style="margin: 0 0 40px 0;">${post["id"]}</div>
            <div>${mediaContent}</div>
                    <div class="d-flex justify-content-between align-items-end" style="bottom: 0;">
                        <label>Дата: ${post["created_at"].split('T')[0]}</label>
                    </div>
            </div>
        </div>
    </div>
</div>
                       ` })
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
