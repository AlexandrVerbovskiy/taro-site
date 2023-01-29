<script>

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

        fd.append('file', input.prop('files')[0]);
        fd.append('type', 'image');

        setFile(fd,
            url => document.querySelector("[name=img_src]").value = url);
    }

    function setUrl() {
        const input = $("#file_input");
        const type = $("#media_type");
        const fd = new FormData;

        fd.append('file', input.prop('files')[0]);
        fd.append('type', type.prop('value'));

        setFile(fd,
            url => {
                document.querySelector("#url").value = url;
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
