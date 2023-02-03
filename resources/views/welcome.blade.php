@include('layouts.main-header')
<div class="row justify-content-center">
<div class="shapka text-center col-lg-8">
    <img class="rounded mx-auto d-block " src=" {{ URL("image/123.jpg") }}" style="width: 100%; height: auto;">
</div>
</div>
<div class="text-center fw-bold" style="font-size: 50px; margin: 20px;">Валерій</div>
<div class="container">
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.
</div>
<br>
<div class="container text-center">
    <button type="button" class="btn btn-primary">Записатися</button>
    <div class="d-flex flex-column">
        <br>
        <div>Оберіть дату та час</div>
        <div>
        </div>
    </div>
</div>

<script>
    export default {
        data() {
            return {
                value: '',
                context: null
            }
        },
        methods: {
            onContext(ctx) {
                this.context = ctx
            }
        }
    }
</script>
@include('layouts.footer')
