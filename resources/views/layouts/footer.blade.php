<footer class="d-flex flex-column justify-content-center text-center footer mt-auto" style="background-color: #a9c6ff; z-index: 2">
    <div class="footer_text">Контакти</div>
    <div class="d-flex flex-row justify-content-center">
        <div><a href="#"><img src="{{ URL("image/instagram.png")}}" class="footer-image"></a></div>
        <div><a href="#"><img src="{{ URL("image/youtube.png") }}" class="footer-image"></a></div>
        <div><a href="#"><img src="{{ URL("image/facebook.png") }}" class="footer-image"></a></div>
    </div>
</footer>

<script src="https://cdn.ckeditor.com/4.20.1/full/ckeditor.js"></script>
<script>
    if (document.querySelector("#editor")) {
        CKEDITOR.replace('editor');
    }
</script>

<script>
    function exitLogin() {
        $('#login').modal('toggle');
    }

    if (document.querySelector(".lang_button"))
        document.querySelectorAll(".lang_button").forEach(elem => elem.addEventListener("click", e => changeLanguage(e.target.dataset.value)));

    const lang = localStorage.getItem("language") ?? "ua";

    changeLanguage(lang);


    $(document).ready(function () {
        if ($(".form").length > 0) {
            $('.form').keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        }
    });

    function setFile(body, callback) {
        fetch('{{url('/file-save')}}', {
            headers: {
                'X-CSRF-TOKEN': <?=json_encode(csrf_token())?>
            },
            method: 'POST',
            body
        }).then(res => res.json()).then(data => callback(data.filename));
    }

    function setImage() {
        const input = $("#img_input");
        const fd = new FormData;

        if (input.prop('files').length < 1) return;

        fd.append('file', input.prop('files')[0]);
        fd.append('type', 'image');

        setFile(fd,
            url => {
                document.querySelector("#img_src").value = url;
                document.querySelector("#img_src").dispatchEvent(new Event("change", {
                    bubbles: !0,
                    cancelable: !1
                }));
            });
    }

    function setUrl() {
        const input = $("#file_input");
        const type = $("#media_type");
        const fd = new FormData;

        if (input.prop('files').length < 1) return;

        fd.append('file', input.prop('files')[0]);
        fd.append('type', type.prop('value'));

        setFile(fd,
            url => {
                document.querySelector("#url").value = url;
                document.querySelector("#url").dispatchEvent(new Event("change", {
                    bubbles: !0,
                    cancelable: !1
                }));
            })
    }

    if ($("#img_input").length > 0) {
        $("#img_input").on("change", function () {
            setImage();
        })
    }

    if ($("#file_input").length > 0 && $("#media_type").length > 0) {
        $("#file_input").on("change", function () {
            setUrl();
        })
    }


</script>

</body>
</html>
