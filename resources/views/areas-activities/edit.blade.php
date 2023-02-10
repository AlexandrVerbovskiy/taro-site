@include('layouts.header')
<div class="container py-4">
    <h2>Topic</h2>
    <form class='form' method="POST" action="{{url('/admin/save-activity')}}">
        {{ csrf_field() }}

        @if(isset($id))
            <input type="hidden" class="form-control"
                   value="{{$id}}"
                   id="id" name="id">
        @endif

        <div class="form-group mb-3">
            <label for="title_ua">Topic name(ua):</label>
            <input type="text" class="form-control" id="title_ua"
                   value="{{old('title_ua')?old('title_ua'):(isset($title_ua)?$title_ua:'')}}"
                   name="title_ua" required>
        </div>

        <div class="form-group mb-3">
            <label for="title_ru">Topic name(ru):</label>
            <input type="text" class="form-control" id="title_ru"
                   value="{{old('title_ru')?old('title_ru'):(isset($title_ru)?$title_ru:'')}}"
                   name="title_ru" required>
        </div>

        <div class="form-group mb-3">
            <label for="title_ru">Type:</label>
            <select id="type" name="type" required>
                <?php $saved_type = old('type') ? old('type') : (isset($type) ? $type : 'normal')?>
                @if($saved_type=='basic')
                    <option value="basic" selected>Normal</option>
                    <option value="additional">Dop</option>
                @else
                    <option value="basic">Normal</option>
                    <option value="additional" selected>Dop</option>
                @endif
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="body">Body:</label>
            <textarea class="form-control" id="body" name="body"
                      required>{{old('body')?old('body'):(isset($body)?$body:'')}}</textarea>
        </div>

        <input type="hidden" name="img_src"
               value="{{old('img_src')?old('img_src'):(isset($img_src)?$img_src:'')}}"
               required>

        <div class="form-group">
            <button style="cursor:pointer" id="save_changes_fake" type="button" class="btn btn-primary">Save</button>
            <button style="cursor:pointer; display: none;" id="save_changes" type="submit" class="btn btn-primary">
                Save
            </button>
        </div>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>

    <input accept="image/*" type="file" name="img" id="img_input">


</div>
<script>

    $(document).ready(function () {
        $('.form').keydown(function (event) {
            if (event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
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

    $("#save_changes_fake").on("click", function () {
        if (document.querySelector("[name='img_src']").value) {
            $("#save_changes").click();
        } else {
            alert("error");
        }
    })

</script>
@include('layouts.footer')
