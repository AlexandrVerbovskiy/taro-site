@include('layouts.main-header')
<div class="container">
    <h3 class="text-center title_margin infos_title" style="margin: 110px 0 30px">
        Корисна інформація
    </h3>
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
                        mediaContent = `<div class="text-center"><iframe id="youtube_media_view" class="youtube_media" style="border-radius: 15px; margin-bottom: 10px; margin-top: 10px" src="${parseYoutubeUrl(post['url'])}"></iframe></div>`
                        break;
                    case "audio":
                        mediaContent = `<audio style="max-width:100%; max-height:400px; margin-bottom: 15px; margin-top: 9px" controls="" id="audio_media_view" src="/storage/audios/${post['url']}"></audio>`
                        break;
                    case "video":
                        mediaContent = `<div class="text-center"><video style="max-width:100%; max-height:620px; margin: 10px 0 20px; border-radius: 15px;" controls="" id="video_media_view" src="/storage/videos/${post['url']}"></video></div>`;
                        break;
                    case "image":
                        mediaContent=`<div class="text-center"><div class="row justify-content-center" style="width: 100%; margin: 0;">
                                        <div class="col-lg-8" style="padding: 0">
                                            <img style="max-width:100%; max-height:400px; margin-bottom: 20px; margin-top: 10px" id="image_media_view" src="/storage/images/${post['url']}">
                                        </div>
                                      </div></div>`;
                        break;
                }
                rows += `
<div class="row justify-content-center" style="width: 100%; margin: 0;">
    <div class="col-lg-9 col-md-12" style="background-color: #a9c6ff; border-radius: 25px; padding: 20px; margin-bottom: 50px; height: auto;">
        <div class="d-flex flex-column">
            <div><h3>${post["title"]}</h3></div>
            <div>${mediaContent}</div>
            <div>${post["body"]}</div>
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
