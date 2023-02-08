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
        background: #f1f1f1;
        text-align: center;
        height: calc(100vh - 56px);
        padding: 0;
    }

    .admin-menu a {
        text-decoration: none;
        color: #666;
    }

    .admin-menu ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style-image: none;
    }

    .admin-menu li {
        display: block;
        padding: 15px 0 15px 0;
    }

    .admin-menu li:hover {
        background: #ffffff;
    }

    .hamburger {
        background: none;
        position: absolute;
        top: 0;
        right: 0;
        line-height: 45px;
        padding: 5px 15px 0px 15px;
        color: #999;
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
        color: #999;
        border: 0;
        font-size: 3em;
        line-height: 65px;
        font-weight: bold;
        cursor: pointer;
        outline: none;
        z-index: 10000000000000;
    }

    .menu {
        z-index: 1000000;
        font-weight: bold;
        font-size: 0.8em;
        width: 100%;
        background: #f1f1f1;
        position: absolute;
        text-align: center;
        font-size: 12px;
    }

    .menu ul {
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style-image: none;
    }

    .menu li {
        display: block;
        padding: 15px 0 15px 0;
        border-bottom: #dddddd 1px solid;
    }

    .menu li:hover {
        display: block;
        background: #ffffff;
        padding: 15px 0 15px 0;
        border-bottom: #dddddd 1px solid;
    }

    .menu ul li a {
        text-decoration: none;
        margin: 0px;
        color: #666;
    }

    .menu ul li a:hover {
        color: #666;
        text-decoration: none;
    }

    .menu a {
        text-decoration: none;
        color: #666;
    }

    .menu a:hover {
        text-decoration: none;
        color: #666;
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

    .loader.hidden{
        display: none;
    }

</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Navbar</a>
        <button class="hamburger d-lg-none">&#9776;</button>
        <button class="cross d-lg-none">&#735;</button>
    </div>
</nav>

<div class="menu" style="position: relative;">
    <ul>
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
        <a href="{{url("/admin/events-topics")}}">
            <li>EVENTS TOPICS</li>
        </a>
        <a href="{{url("/admin/events")}}">
            <li>EVENTS</li>
        </a>
    </ul>
</div>

<div class="container" style="padding: 0; margin: 0; max-width: 100%;">
    <main class="row" style="width:100%">
        <div class="admin-menu d-none d-lg-block col-lg-3">
            <ul>
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
                <a href="{{url("/admin/events-topics")}}">
                    <li>EVENTS TOPICS</li>
                </a>
                <a href="{{url("/admin/events")}}">
                    <li>EVENTS</li>
                </a>
            </ul>
        </div>
        <div class="col-12 col-lg-9">
            @yield('content')
        </div>
    </main>
</div>

<script>
    $(document).ready(function () {

        $(".cross").hide();
        $(".menu").hide();
        $(".hamburger").click(function () {
            $(".menu").slideToggle("slow", function () {
                $(".hamburger").hide();
                $(".cross").show();
            });
        });

        $(".cross").click(function () {
            $(".menu").slideToggle("slow", function () {
                $(".cross").hide();
                $(".hamburger").show();
            });
        });

    });
</script>
