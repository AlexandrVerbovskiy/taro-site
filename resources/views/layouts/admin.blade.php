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
        min-height: calc(100vh - 172px);
        background-color: #CEDFFF;
        text-align: center;
        padding: 0;
        position: relative;
        height:auto;
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
        z-index: 10;
        position: relative;
        background: #CEDFFF;
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
        padding: 5px 15px 0 15px;
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
        top: 0;
        right: 0;
        padding: 7px 15px 0 15px;
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
        width: 100%;
        background: #a9c6ff;
        position: absolute;
        text-align: center;
        font-size: 12px;
        margin: 0;
    }

    .menu_2 ul {
        z-index: 10;
        margin: 0;
        padding: 0;
        list-style-type: none;
        list-style-image: none;
        background: #a9c6ff;
    }

    .menu_2 li {
        display: block;
        padding: 15px 0 15px 0;
        background: #a9c6ff;
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
        margin: 0;
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

    .scroller {
        position: fixed;
        width: 100px;
        z-index: 1;
        bottom: 130px;
        left: calc(12.5% - 115px);
        transform: translate(50%);
        display: none;
        background-color: #a9c6ff;
        border: 0;
        border-radius: 10px;
        padding: 6px 14px;
        margin: 0 15px 15px;
        text-decoration: none;
        color: white;
    }

    .scroller.visible{
        display: block;
    }

    #admin_scrollup_trigger {
        position: absolute;
        top: 150%;
        background-color: transparent;
    }
    .scroll_for_crop{
        background: #a9c6ff;
        width: auto;
        height: 350px;
        overflow: auto;
    }
    @media only screen and (max-width: 430px) {
        .scroll_for_crop{
            height: 450px;
        }
    }
    @media only screen and (max-width: 380px) {
        .menu_2 li {
            display: block;
            padding: 10px 0;
            background: #a9c6ff;
            /*border-bottom: #dddddd 1px solid;*/
        }
        .menu_2 ul li a {
            text-decoration: none;
            margin: 0;
            color: black;
            font-size: 10px;
        }
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light"
     style="background-color: #a9c6ff; margin: 0; z-index: 10000000000000000000000; width: 100%; position: fixed">
    <div class="container-fluid" style="">
        <a class="navbar-brand" style="font-family: 'Oswald', sans-serif; font-size: 24px; padding: 2px 0" href="/">Адмін
            панель</a>
        <button class="hamburger d-lg-none">&#9776;</button>
        <button class="cross d-lg-none">&#735;</button>
    </div>
</nav>


<div class="menu_2 d-lg-none " style="position: fixed; margin: 56px 0 0 0">
    <ul class="scroll_for_crop" style="">
        <a href="{{url("/")}}">
            <li>Основна сторінка</li>
        </a>
        <a href="{{url("/admin/main-settings")}}">
            <li>Головна</li>
        </a>
        <a href="{{url("/admin/calendar")}}">
            <li>Календар</li>
        </a>
        <a href="{{url("/admin/users")}}">
            <li>Користувачі</li>
        </a>
        <a href="{{url("/admin/activities")}}">
            <li>Напрямки діяльності</li>
        </a>
        <a href="{{url("/admin/masters")}}">
            <li>Майстри</li>
        </a>
        <a href="{{url("/admin/infos")}}">
            <li>Корисна інформація (категорії)</li>
        </a>
        <a href="{{url("/admin/infos-posts")}}">
            <li>Корисна інформація (пости)</li>
        </a>
        <a href="{{url("/admin/studies-topics")}}">
            <li>Навчання (категорії)</li>
        </a>
        <a href="{{url("/admin/studies")}}">
            <li>Навчання (пости)</li>
        </a>
        <a href="{{url("/admin/events-topics")}}">
            <li>Події (категорії)</li>
        </a>
        <a href="{{url("/admin/events")}}">
            <li>Події (пости)</li>
        </a>
        <a href="{{url("/admin/comments")}}">
            <li>Коментарі</li>
        </a>
        <a href="{{url("/admin/notes-to-studies")}}">
            <li>Записи на навчання</li>
        </a>
        <a href="{{url("/admin/notes-to-masters")}}">
            <li>Записи на майстра</li>
        </a>
    </ul>
</div>

<div class="container" style="padding: 0; margin: 0; max-width: 100%;">
    <main class="row" style="width:100%; padding: 0; margin: 56px 0 0">
        <div class="admin-menu d-none d-lg-block col-lg-3">
            <div style="position: relative;">
                <ul style="padding-bottom: 20px;">
                    <a href="{{url("/")}}">
                        <li>Основна сторінка</li>
                    </a>
                    <a href="{{url("/admin/main-settings")}}">
                        <li>Головна</li>
                    </a>
                    <a href="{{url("/admin/calendar")}}">
                        <li>Календар</li>
                    </a>
                    <a href="{{url("/admin/users")}}">
                        <li>Користувачі</li>
                    </a>
                    <a href="{{url("/admin/activities")}}">
                        <li>Напрямки діяльності</li>
                    </a>
                    <a href="{{url("/admin/masters")}}">
                        <li>Майстри</li>
                    </a>
                    <a href="{{url("/admin/infos")}}">
                        <li>Корисна інформація (категорії)</li>
                    </a>
                    <a href="{{url("/admin/infos-posts")}}">
                        <li>Корисна інформація (пости)</li>
                    </a>
                    <a href="{{url("/admin/studies-topics")}}">
                        <li>Навчання (категорії)</li>
                    </a>
                    <a href="{{url("/admin/studies")}}">
                        <li>Навчання (пости)</li>
                    </a>
                    <a href="{{url("/admin/events-topics")}}">
                        <li>Події (категорії)</li>
                    </a>
                    <a href="{{url("/admin/events")}}">
                        <li>Події (пости)</li>
                    </a>
                    <a href="{{url("/admin/comments")}}">
                        <li>Коментарі</li>
                    </a>
                    <a href="{{url("/admin/notes-to-studies")}}">
                        <li>Записи на навчання</li>
                    </a>
                    <a href="{{url("/admin/notes-to-masters")}}">
                        <li>Записи на майстра</li>
                    </a>
                </ul>
                <div id="admin_scrollup_trigger"></div>
            </div>

            <button id="btn_scroll_up" class="scroller">Догори</button>
        </div>
        <div class="col-12 col-lg-9">
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

    const btn_scroll_up = document.querySelector('#btn_scroll_up');

    btn_scroll_up.addEventListener('click', function () {
        window.scrollTo({top: 0, behavior: 'smooth'});
    });


    let isPrevUnder = false;
    const element = document.querySelector('#admin_scrollup_trigger');
    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (!isPrevUnder) {
                    isPrevUnder = true;
                    btn_scroll_up.classList.add("visible");
                    console.log('Елемент з\'явився на екрані');
                }
            } else {
                if (entry.boundingClientRect.bottom < 0) {
                    console.log('Елемент над екраном');
                } else if (entry.boundingClientRect.top > window.innerHeight) {
                    console.log('Елемент під екраном');
                    btn_scroll_up.classList.remove("visible");
                    isPrevUnder = false;
                } else {
                    console.log('Елемент частково видно на екрані');
                }
            }
        });
    });

    observer.observe(element);

    document.querySelectorAll(".loader").forEach(elem=>{
        elem.insertAdjacentHTML("beforeend", `<div class="spinner-border" role="status"><span class="sr-only"></span></div>`)
    })

</script>


@include('layouts.footer')
