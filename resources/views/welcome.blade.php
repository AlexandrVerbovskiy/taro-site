@include('layouts.main-header')
<div class="row justify-content-center" style="width: 100%; margin: 0px">
<div class="shapka text-center col-lg-8" style="padding: 0; margin-top: 80px">
    <img class="" src=" {{ URL("image/123.jpg") }}" style="width: 100%; height: auto;">
</div>
</div>


<h3 class="text-center" style=" margin: 20px;">Валерій</h3>
<div class="container main_text">
    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt.
</div>



<div class="container text-center">
    @if (!auth()->check())
        <a type="button" class="btn btn-primary button_for_valera @if(Request::segment(1) == 'login') active @endif" href="{{url("/login")}}"
           type="submit" data-bs-toggle="modal" data-bs-target="#login">Увійти</a>
        <div class="d-flex flex-column">
            <div style="font-size: 12px; margin: 20px 0 60px">
                Запис доступний тільки після входу до акаунту на сайті, для цього натисніть на кнопку “Увійти”,
                якщо ви вперше на нашому сайті, то на сторінці входу ви зможете зареєструвати новий акаунт.
            </div>
        </div>

    @else
        <button type="button" class="btn btn-primary button_for_valera">Записатися</button>
        <div class="d-flex flex-column">
            <br>
            <div>Оберіть дату та час</div>
            <div>
                Test 2
            </div>
        </div>
    @endif

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
