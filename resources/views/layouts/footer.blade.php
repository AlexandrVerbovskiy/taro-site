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

    function setimage() {
        const input = $("#img_input");
        const fd = new FormData;

        fd.append('img', input.prop('files')[0]);

        fetch('{{url('/file-save')}}', {
            headers: {
                'X-CSRF-TOKEN': document.querySelector('[name=_token]').getAttribute('value')
            },
            method: 'POST',
            body: fd
        }).then(res => res.json()).then(data => {
            document.querySelector("[name='img_src']").value = data.filename;
        });
    }


    if ($("#img_input").length > 0) {
        $("#img_input").on("change", function () {
            setimage();
        })
    }
</script>

</body>
</html>
