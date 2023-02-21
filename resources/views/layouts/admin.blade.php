@include('layouts.header')

<style>
    body {
        font-family: 'Noto Sans', sans-serif;
        margin: 0;
        width: 100%;
        height: 100vh;
        background: #ffffff;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    header {
        width: 100%;
        background: #ffffff;
        height: 60px;
        line-height: 60px;
        border-bottom: 1px solid #dddddd;

    }

    .admin-menu {
        font-weight: bold;
        font-size: 0.8em;
        background-color: #CEDFFF;
        text-align: center;
        height: calc(100vh);
        max-height: 20000px;
        padding: 0;
        width: 400px;
        /*position: fixed;
        margin: 0;*/

    }
    .admin-background{
        width: 400px;
        height: 100%;
        position: fixed;
        background-color: #CEDFFF;
        z-index: -1;
    }
    .admin-menu a {
        text-decoration: none;
        color: black;
    }

    .admin-menu ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style-image: none;
        position: fixed;
        width: 400px;
    }

    .admin-menu li {
        display: block;
        padding: 15px 0 15px 0;
    }

    .admin-menu li:hover {
        background: #a9c6ff;
    }

    .hamburger {
        background: none;
        position: absolute;
        top: 0;
        right: 0;
        line-height: 45px;
        padding: 5px 15px 0px 15px;
        color: black;
        border: 0;
        font-size: 1.4em;
        font-weight: bold;
        cursor: pointer;
        outline: none;
        z-index: 10000000000000;
    }

    .cross {
        background: none;
        position: absolute;
        top: 0px;
        right: 0;
        padding: 7px 15px 0px 15px;
        color: black;
        border: 0;
        font-size: 3em;
        line-height: 65px;
        font-weight: bold;
        cursor: pointer;
        outline: none;
        z-index: 10000000000000;
    }

    .menu_2 {
        z-index: 1000000;
        font-weight: bold;
        font-size: 0.8em;
        width: 100%;
        background: #a9c6ff;
        position: absolute;
        text-align: center;
        font-size: 12px;
        margin: 0;
    }

    .menu_2 ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style-image: none;
        background: #a9c6ff;
    }

    .menu_2 li {
        display: block;
        padding: 15px 0 15px 0;
        /*border-bottom: #dddddd 1px solid;*/
    }

    .menu_2 li:hover {
        display: block;
        background: #CEDFFF;
        padding: 15px 0 15px 0;
        /*border-bottom: #dddddd 1px solid;*/
    }

    .menu_2 ul li a {
        text-decoration: none;
        margin: 0px;
        color: black;
    }

    .menu_2 ul li a:hover {
        color: black;
        text-decoration: none;
    }

    .menu_2 a {
        text-decoration: none;
        color: black;
    }

    .menu_2 a:hover {
        text-decoration: none;
        color: black;
    }

    .glyphicon-home {
        color: white;
        font-size: 1.5em;
        margin-top: 5px;
        margin: 0 auto;
    }

    header {
        display: inline-block;
        font-size: 12px;
    }

    span {
        padding-left: 20px;
    }

    a {
        color: #336699;
    }

    .loader.hidden {
        display: none;
    }
    @media only screen and (max-width: 1440px) {
        .admin-menu{
            width: 330px;
        }
        .admin-menu ul{
            width: 330px;
        }
        .admin-background{
            width: 330px;
        }
    }
    @media only screen and (max-width: 1280px) {
        .admin-menu{
            width: 280px;
        }
        .admin-menu ul{
            width: 280px;
        }
        .admin-background{
            width: 280px;
        }
    }
    @media only screen and (max-width: 1120px) {
        .admin-menu{
            width: 240px;
        }
        .admin-menu ul{
            width: 240px;
        }
        .admin-background{
            width: 240px;
        }

    }
    @media only screen and (max-width: 1024px) {
        .admin-menu{
            width: 200px;
        }
        .admin-menu ul{
            width: 200px;
        }
        .admin-background{
            width: 200px;
        }
        .admin-menu ul a li{
            font-size: 11px;
        }
    }
    @media only screen and (max-width: 992px) {
        .admin-background{
            background: none;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #a9c6ff; margin: 0; z-index: 10000000000000000000000; width: 100%; position: fixed">
    <div class="container-fluid" style="">
        <a class="navbar-brand" style="font-family: 'Oswald', sans-serif; font-size: 24px; padding: 2px 0" href="/">Адмін панель</a>
        <button class="hamburger d-lg-none">&#9776;</button>
        <button class="cross d-lg-none">&#735;</button>
    </div>
</nav>

<div class="menu_2 d-lg-none " style="position: fixed; margin: 55px 0 0 0">
    <ul style="background: #a9c6ff;">
        <a href="{{url("/admin/calendar")}}">
            <li>Calendar</li>
        </a>
        <a href="{{url("/admin/main-settings")}}">
            <li>Main</li>
        </a>
        <a href="{{url("/admin/users")}}">
            <li>USERS</li>
        </a>
        <a href="{{url("/admin/activities")}}">
            <li>ACTIVITIES</li>
        </a>
        <a href="{{url("/admin/masters")}}">
            <li>MASTERS</li>
        </a>
        <a href="{{url("/admin/infos")}}">
            <li>INFOS</li>
        </a>
        <a href="{{url("/admin/infos-posts")}}">
            <li>INFOS POSTS</li>
        </a>
        <a href="{{url("/admin/studies-topics")}}">
            <li>STUDIES TOPICS</li>
        </a>
        <a href="{{url("/admin/studies")}}">
            <li>STUDIES</li>
        </a>
        <a href="{{url("/admin/events-topics")}}">
            <li>EVENTS TOPICS</li>
        </a>
        <a href="{{url("/admin/events")}}">
            <li>EVENTS</li>
        </a>
        <a href="{{url("/admin/main-settings")}}">
            <li>Main</li>
        </a>
        <a href="{{url("/admin/comments")}}">
            <li>Comments</li>
        </a>
        <a href="{{url("/admin/notes-to-studies")}}">
            <li>Записи на навчання</li>
        </a>
        <a href="{{url("/admin/notes-to-masters")}}">
            <li>Записи на майстра</li>
        </a>
    </ul>
</div>

<div class="admin-background" style=""></div>
<div class="container" style="padding: 0; margin: 0; max-width: 100%;">
    <main class="row" style="width:100%; padding: 0; margin: 0;">
        <div class="admin-menu d-none d-lg-block col-lg-3" style="margin-top: 56px">
            <ul>
                <a href="{{url("/admin/calendar")}}">
                    <li>Calendar</li>
                </a>
                <a href="{{url("/admin/main-settings")}}">
                    <li>Main</li>
                </a>
                <a href="{{url("/admin/users")}}">
                    <li>USERS</li>
                </a>
                <a href="{{url("/admin/activities")}}">
                    <li>ACTIVITIES</li>
                </a>
                <a href="{{url("/admin/masters")}}">
                    <li>MASTERS</li>
                </a>
                <a href="{{url("/admin/infos")}}">
                    <li>INFOS</li>
                </a>
                <a href="{{url("/admin/infos-posts")}}">
                    <li>INFOS POSTS</li>
                </a>
                <a href="{{url("/admin/studies-topics")}}">
                    <li>STUDIES TOPICS</li>
                </a>
                <a href="{{url("/admin/studies")}}">
                    <li>STUDIES</li>
                </a>
                <a href="{{url("/admin/events-topics")}}">
                    <li>EVENTS TOPICS</li>
                </a>
                <a href="{{url("/admin/events")}}">
                    <li>EVENTS</li>
                </a>
                <a href="{{url("/admin/main-settings")}}">
                    <li>Main</li>
                </a>
                <a href="{{url("/admin/comments")}}">
                    <li>Comments</li>
                </a>
                <a href="{{url("/admin/notes-to-studies")}}">
                    <li>Записи на навчання</li>
                </a>
                <a href="{{url("/admin/notes-to-masters")}}">
                    <li>Записи на майстра</li>
                </a>
            </ul>
        </div>
        <div class="col-12 col-lg-9 message-parent" style="padding: 0; margin: 0;">
            @if($errors->any())
                <div style="border-radius: 0 0 10px 10px;" class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{$errors->first()}}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

</div>

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
