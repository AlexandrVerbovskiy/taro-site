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
            <a data-value="ua" class="link-dark text-decoration-none lang_button">UA</a>
            <a data-value="ru" class="link-dark text-decoration-none lang_button" style="margin-left: 20px">RUS</a>
        </div>
    </div>
</header>
<div class="collapse navbar-collapse menu" id="navbarNav" style="">
    <ul class="nav flex-column" id="nav_accordion">

        @if(auth()->check() && auth()->user()->admin)
            <li class="nav-item">
                <a class="nav-link link-dark" href="{{url('/admin')}}"> Адмін </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item1" href="#"> Напрямки
                діяльності <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item1" class="submenu collapse" data-bs-parent="#nav_accordion">

                <li>
                    <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item3" href="#">
                        Основні <i class="bi small bi-caret-down-fill"></i> </a>
                    <ul id="menu_item3" class="submenu collapse" data-bs-parent="#menu_item1">
                        @foreach ($activities_topics as $activity_topic)
                            @if($activity_topic['type']=="basic")
                                <li><a class="nav-link link-dark"
                                       href="{{url('/area-activity/'.$activity_topic['id'])}}">{{$activity_topic['title_ua']}} </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
                <li>
                    <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item4" href="#">
                        Додаткові <i class="bi small bi-caret-down-fill"></i> </a>
                    <ul id="menu_item4" class="submenu collapse" data-bs-parent="#menu_item1">
                        @foreach ($activities_topics as $activity_topic)
                            @if($activity_topic['type']=="additional")
                                <li><a class="nav-link link-dark"
                                       href="{{url('/area-activity/'.$activity_topic['id'])}}">{{$activity_topic['title_ua']}} </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" href="/masters"> Майстри </a>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item2" href="#"> Навчання <i
                    class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item2" class="submenu collapse" data-bs-parent="#nav_accordion">
                @foreach ($studies_topics as $study_topic)
                    <li><a class="nav-link link-dark" href="{{url("/studies/".$study_topic['id'])}}">{{$study_topic['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item_infos" href="#"> Корисна інформація </a>
            <ul id="menu_item_infos" class="submenu collapse" data-bs-parent="#nav_accordion">
                @foreach ($infos as $info)
                    <li><a class="nav-link link-dark" href="{{url("/infos-posts/".$info['id'])}}">{{$info['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item5" href="#"> Події <i
                    class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item5" class="submenu collapse" data-bs-parent="#nav_accordion">
                @foreach ($events_topics as $event_topic)
                    <li><a class="nav-link link-dark" href="{{url("/event-posts/".$event_topic['id'])}}">{{$event_topic['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @if (!auth()->check())
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'registration') active @endif"
                   href="{{url("/registration")}} "
                   type="submit" data-bs-toggle="modal" data-bs-target="#register">Registration</a>
            </li>
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'login') active @endif" href="{{url("/login")}}"
                   type="submit" data-bs-toggle="modal" data-bs-target="#login">Login</a>
            </li>
        @else
            <li class="nav-item link-secondary">
                <a class="nav-link link-dark @if(Request::segment(1) == 'logout') active @endif"
                   href="{{url("/logout")}} "
                   type="submit">Logout</a>
            </li>
        @endif
    </ul>
</div>
<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true"
     style="backdrop-filter: blur(15px);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #a9c6ff; border-radius: 25px; border: 0; margin: 0 20px">
            <div class="modal-header d-flex justify-content-center form_header" style="">
                <p class="modal-title" id="exampleModalLongTitle" style="/*font-size: 30px;*/">Реєстрація</p>
            </div>
            <form method="POST" action="{{url('/registration')}}">
                <div class="modal-body padding_for_form">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                        <input type="text" class="form-control input_form" value="{{ old('first_name') }}"
                               id="first_name" name="first_name" placeholder="Ім'я">
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control input_form" value="{{ old('last_name') }}" id="last_name"
                               name="last_name" placeholder="Прізвище">
                    </div>

                    <div class="form-group mb-3">
                        <input type="email" class="form-control input_form" value="{{ old('email') }}" id="email"
                               name="email" placeholder="Пошта">
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control input_form" value="{{ old('phone') }}" id="phone"
                               name="phone" placeholder="Телефон">
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control input_form" value="{{ old('social_type') }}"
                               id="social_type" name="social_type" placeholder="Оберіть соц. мережу">
                        <div class="switch">
                            <div class="element">
                                <input type="radio" name="radio" class="switch-button" id="button1">
                                <label for="button1"><img src="{{ URL("image/telegram.png")}}"
                                                          class="switch-image"></label>
                            </div>
                            <div class="element">
                                <input type="radio" name="radio" class="switch-button" id="button2">
                                <label for="button2"><img src="{{ URL("image/viber.png")}}"
                                                          class="switch-image"></label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <input type="text" class="form-control input_form" value="{{ old('social_phone') }}"
                               id="social_phone" name="social_phone" placeholder="Телефон соц. мережі">
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" class="form-control input_form" id="password" name="password"
                               placeholder="Пароль">
                    </div>

                    <div class="form-group mb-3">
                        <input type="password" class="form-control input_form" id="password_confirmation"
                               name="password_confirmation" placeholder="Повторіть пароль">
                    </div>
                    <div class="text-center d-flex align-items-center justify-content-center" style="height: 40px">
                        @if($errors->any())
                            <p style="font-size: 12px; color: red; margin-bottom: 0">{{$errors->first()}}</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer padding_for_form" style="border: 0; margin-top: -24px">
                    <div class="d-flex justify-content-center" style="width: 100%">
                        <button style="cursor:pointer;" type="submit" class="btn btn-primary form_main_button">
                            Зареєструватися
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true"
     style="backdrop-filter: blur(15px);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #a9c6ff; border-radius: 25px; border: 0; margin: 0 20px">
            <div class="modal-header d-flex justify-content-center"
                 style="border: 0; margin: 18px 0; padding-bottom: 0">
                <p class="modal-title" id="exampleModalLongTitle" style="/*font-size: 30px;*/">Вхід</p>
            </div>
            <form method="POST" action="{{url('/login')}}">
                <div class="modal-body padding_for_form">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                        <input type="email" class="form-control input_form" id="email" value="{{old('email')}}"
                               name="email" placeholder="Пошта">
                    </div>
                    <div class="form-group mb-3">
                        <input type="password" class="form-control input_form" id="password" name="password"
                               placeholder="Пароль">
                    </div>
                    <div class="text-center d-flex align-items-center justify-content-center" style="height: 40px">
                        @if($errors->any())
                            <p style="font-size: 12px; color: red; margin-bottom: 0">{{$errors->first()}}</p>
                        @endif
                    </div>
                </div>
                <div class="modal-footer padding_for_form" style="border: 0; margin-top: -24px">
                    <div class="d-flex justify-content-center" style="width: 100%">
                        <button style="cursor:pointer;" type="submit" class="btn btn-primary form_main_button">Увійти
                        </button>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-1 row-cols-md-2 d-flex justify-content-between"
                         style="width: 100%">
                        <a class="btn btn-primary form_sec_button col @if(Request::segment(1) == 'registration') active @endif"
                           href="{{url("/registration")}} "
                           type="submit" data-bs-target="#register" data-bs-toggle="modal" data-bs-dismiss="modal">Реєстрація</a>
                        <a type="button" class="btn btn-primary form_sec_button col" href="{{url("forget-password")}}">Забули
                            пароль?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    subscribeOnChangeLanguage("#main_title", "title");
</script>
