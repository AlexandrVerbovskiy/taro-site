@include('layouts.header')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Oswald&family=Roboto&display=swap');

    a, div, li, button, input, span, p, label, h2, h3, h4, h5, h6{
        font-family: 'Roboto', sans-serif;
    }
    .nav-link:hover{
        background-color: #CEDFFF;
    }
    .nav-item>.nav-link{
        padding: 10px 28px;
        font-size: 20px;
        color: black;
    }
    .menu_3{
        position: fixed;
        background-color: #a9c6ff;
        margin-top: 55px;
        width: 300px;
        box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.25);
    }
    ul>li>a{
        padding-left: 4px;
        font-size: 20px;

    }


    .img_menu{
        width: 30px;
        padding: 0;
    }
    .header_name{
        font-family: 'Oswald', sans-serif;
        font-size: 30px;
        color: black;
        text-decoration: none;
    }
    .lang_button{
        font-family: 'Oswald', sans-serif;
        font-size: 20px;
        margin: 0 10px;
        cursor: pointer;
        text-decoration: none;
        color: black;
    }
    .lang_button:hover {
        color: black;
    }

    .lang_button:hover{
        color: black;
        text-decoration: underline;
    }

    .lang_button_change{
        text-decoration: underline;
        color: #336699;
    }

    .switch-button:checked + label {
        background: #3378FF;
    }
    @media only screen and (max-width: 1440px) {

        .nav-item>.nav-link{
            padding: 8px 20px;
            font-size: 16px;
        }
        .menu_3{
            width: 260px;
        }
        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
            margin: 0 0px;
        }

    }
    @media only screen and (max-width: 1280px) {

        .nav-item>.nav-link{
            padding: 7px 20px;
            font-size: 15px;
        }
        .menu_3{
            width: 260px;
        }
        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
            margin: 0 0px;
        }

    }
    @media only screen and (max-width: 1024px) {

        .nav-item>.nav-link{
            padding: 7px 20px;
            font-size: 14px;
        }
        .menu_3{
            width: 260px;
        }
        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
            margin: 0 0px;
        }

    }
    @media only screen and (max-width: 540px) {

        .nav-item>.nav-link{
            font-size: 18px;
        }
        ul>li>a{
            font-size: 18px;
        }
        .menu_3{
            width: 260px;
        }
        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
            margin: 0 0px;
        }

    }
    @media only screen and (max-width: 430px) {

        .nav-item>.nav-link{
            font-size: 16px;
        }
        ul>li>a{
            font-size: 16px;
        }
        .menu_3{
            width: 260px;
        }

        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 22px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 17px;
            margin: 0 0px;
        }

    }


    @media only screen and (max-width: 400px) {

        .nav-item>.nav-link{
            font-size: 16px;
        }
        .menu_3{
            width: 240px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 17px;
            margin: 0 0px;
        }
        .img_menu{
            width: 25px;
            height: 25px;
        }

        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
        }


    }

    @media only screen and (max-width: 368px) {
        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 18px;
        }
        .img_menu{
            width: 20px;
            padding: 0;
        }

        .nav-item>.nav-link{
            padding: 12px 28px;
            font-size: 18px;
        }

        .nav-item>.nav-link{
            font-size: 16px;
        }

        .menu_3{
            width: 240px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            margin: 0 0px;
        }
    }
    @media only screen and (max-width: 320px) {
        .header_name{
            font-family: 'Oswald', sans-serif;
            font-size: 17px;
        }
        .nav-item>.nav-link{
            padding: 8px 20px;
            font-size: 13px;
        }
        ul>li>a{
            font-size: 13px;
        }
        .menu_3{
            width: 200px;
        }
        .lang_button{
            font-family: 'Oswald', sans-serif;
            font-size: 14px;
            margin: 0 0px;
        }
    }


</style>
<header class="align-items-center"
        style="background-color: #a9c6ff; height: 56px; z-index: 10; width: 100%; position: fixed">
    <div class="row align-items-center" style="width: 100%; margin: 0; height: 56px; ">
        <div class="col">
            <div class="container-fluid d-flex justify-content-start" style="padding: 0px;">
                <a class="navbar-toggler collapsed d-flex flex-column justify-content-around link-dark text-decoration-none text-reset"
                   type="button"
                   data-bs-toggle="collapse" data-bs-target="#navbarNav2" aria-controls="navbarNav2"
                   aria-expanded="false" aria-label="Toggle navigation">
                    <img class="img_menu" src="{{ URL("image/menu.png")}}">
                </a>
            </div>
        </div>
        <div class="col">
            <div class="bd-highlight  text-center " style="">
                <a id="main_title" class="link-dark header_name" href="/">Адмін панель</a>

            </div>
        </div>
        <div class="col d-flex justify-content-end">
            <a data-value="ua" class="lang_button" id="ua_lang" style="">UA</a>
            <a data-value="ru" class="lang_button" id="ru_lang" style="margin-left: 20px">RUS</a>

        </div>
    </div>
</header>
<div class="collapse navbar-collapse menu_3" id="navbarNav2" style="z-index: 3">
    <ul class="nav flex-column" >
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/calendar")}}">Календар</a>
        </li>
        <li class="nav-item text-decoration-none" >
            <a class="nav-link" href="{{url("/admin/main-settings")}}">Головна</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/users")}}">Користувачі</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/activities")}}">Напрямки діяльності</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/masters")}}">Майстри</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/infos")}}">Корисна інформація (категорії)</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/infos-posts")}}">Корисна інформація (пости)</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/studies-topics")}}">Навчання (категорії)</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/studies")}}">Навчання (пости)</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/events-topics")}}">Події (категорії)</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/events")}}">Події (пости)</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/comments")}}">Коментарі</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/notes-to-studies")}}">Записи на навчання</a>
        </li>
        <li class="nav-item text-decoration-none">
            <a class="nav-link" href="{{url("/admin/notes-to-masters")}}">Записи на майстра</a>
        </li>
    </ul>
</div>
@yield('content')




<script>
    $(document).ready(function () {

        $(".cross").hide();
        $(".menu_2").hide();
        $(".hamburger").click(function () {
            $(".menu_2").slideToggle("slow", function () {
                $(".hamburger").hide();
                $(".cross").show();
            });
        });

        $(".cross").click(function () {
            $(".menu_2").slideToggle("slow", function () {
                $(".cross").hide();
                $(".hamburger").show();
            });
        });

    });
</script>
@include('layouts.footer')
