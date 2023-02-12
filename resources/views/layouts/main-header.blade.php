@include('layouts.header')
<!--<header class="d-flex justify-content-between align-items-center" style="background-color: #a9c6ff; height: 70px;">
    <div class="">
        <div class="container-fluid">
            <a class="navbar-toggler collapsed d-flex flex-column justify-content-around link-dark text-decoration-none text-reset" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">B</span>
            </a>
        </div>
    </div>
    <div class="bd-highlight">HOME</div>
    <div class="bd-highlight">LANG</div>
</header>-->
<header class="align-items-center"
        style="background-color: #a9c6ff; height: 80px; z-index: 10; width: 100%; position: fixed">
    <div class="row align-items-center" style="width: 100%; margin: 0; height: 80px; ">
        <div class="col">
            <div class="container-fluid d-flex justify-content-start" style="padding: 0px;">
                <a class="navbar-toggler collapsed d-flex flex-column justify-content-around link-dark text-decoration-none text-reset"
                   type="button"
                   data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                   aria-expanded="false" aria-label="Toggle navigation">
                    <img class="img_menu" src="{{ URL("image/menu.png")}}">
                </a>
            </div>
        </div>
        <div class="col-5">
            <div class="bd-highlight  text-center " style="">
                <a id="main_title" class="link-dark header_name" href="/"></a>

            </div>
        </div>
        <div class="col d-flex justify-content-end">
            <a data-value="ua" class="lang_button link-dark" id="lang_but" style="">UA</a>
            <a data-value="ru" class="link-dark lang_button" id="lang_but" style="margin-left: 20px">RUS</a>

        </div>
    </div>
</header>


<script>
    subscribeOnChangeLanguage("#main_title", "title");
    subscribeOnChangeLanguage("#menu_areas", "menu_areas");
    subscribeOnChangeLanguage("#menu_masters", "menu_masters");
    subscribeOnChangeLanguage("#menu_studies", "menu_studies");
    subscribeOnChangeLanguage("#menu_info", "menu_info");
    subscribeOnChangeLanguage("#menu_events", "menu_events");
    subscribeOnChangeLanguage("#menu_register", "menu_register");
    subscribeOnChangeLanguage("#menu_login", "menu_login");
    subscribeOnChangeLanguage("#menu_logout", "menu_logout");



</script>
