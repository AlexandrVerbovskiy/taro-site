@include('layouts.header')
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
            <a data-value="ua" class="lang_button" id="ua_lang" style="">UA</a>
            <a data-value="ru" class="lang_button" id="ru_lang" style="margin-left: 20px">RUS</a>

        </div>
    </div>
</header>
@include('layouts.menu')

<script>
    subscribeOnChangeLanguage("#main_title", "title");
    subscribeOnChangeLanguage("#menu_areas", "menu_areas");
    subscribeOnChangeLanguage("#menu_masters", "menu_masters");
    subscribeOnChangeLanguage("#menu_studies", "menu_studies");
    subscribeOnChangeLanguage("#menu_info", "menu_info");
    subscribeOnChangeLanguage("#menu_events", "menu_events");
    subscribeOnChangeLanguage("#popup_register_title", "popup_register_title");
    subscribeOnChangePlaceholderLanguage(".popup_register_name", "popup_register_name");
    subscribeOnChangePlaceholderLanguage(".popup_register_last_name", "popup_register_last_name");
    subscribeOnChangePlaceholderLanguage(".popup_register_email", "popup_register_email");
    subscribeOnChangePlaceholderLanguage(".popup_register_phone", "popup_register_phone");
    subscribeOnChangePlaceholderLanguage(".popup_register_social_type", "popup_register_social_type");
    subscribeOnChangePlaceholderLanguage(".popup_register_social_phone", "popup_register_social_phone");
    subscribeOnChangePlaceholderLanguage(".popup_register_password_confirmation", "popup_register_password_confirmation");
    subscribeOnChangeLanguage(".popup_register_submit", "popup_register_submit");
    subscribeOnChangeLanguage(".popup_login_title", "popup_login_title");
    subscribeOnChangePlaceholderLanguage(".popup_login_email", "popup_login_email");
    subscribeOnChangePlaceholderLanguage(".popup_login_password", "popup_login_password");
    subscribeOnChangeLanguage(".popup_login_submit", "popup_login_submit");
    subscribeOnChangeLanguage(".popup_login_register", "popup_login_register");
    subscribeOnChangeLanguage(".popup_login_forget_password", "popup_login_forget_password");
    subscribeOnChangeLanguage(".popup_forget_password_title", "popup_forget_password_title");
    subscribeOnChangeLanguage(".popup_forget_password_text", "popup_forget_password_text");
    subscribeOnChangePlaceholderLanguage(".popup_forget_password_email", "popup_forget_password_email");
    subscribeOnChangeLanguage(".popup_forget_password_submit", "popup_forget_password_submit");

    if(document.querySelector("#menu_register")) subscribeOnChangeLanguage("#menu_register", "menu_register");
    if(document.querySelector("#menu_login")) subscribeOnChangeLanguage("#menu_login", "menu_login");
    if(document.querySelector("#menu_logout")) subscribeOnChangeLanguage("#menu_logout", "menu_logout");
</script>
