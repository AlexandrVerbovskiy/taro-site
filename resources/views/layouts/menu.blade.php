<div class="collapse navbar-collapse menu_2" id="navbarNav" style="">
    <ul class="nav flex-column" id="nav_accordion">

        @if(auth()->check() && auth()->user()->admin)
            <li class="nav-item">
                <a class="nav-link link-dark" href="{{url('/admin')}}"> Адмін </a>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item1" href="#"
               id="menu_areas"> Напрямки
                діяльності <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item1" class="submenu collapse" data-bs-parent="#nav_accordion">

                <li>
                    <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item3" href="#">
                        Основні <i class="bi small bi-caret-down-fill"></i> </a>
                    <ul id="menu_item3" class="submenu collapse" data-bs-parent="#menu_item1">
                        @foreach ($activities_topics as $key=>$activity_topic)
                            @if($activity_topic['type']=="basic")
                                <li><a class="nav-link link-dark"
                                       id="activity_topic_{{$key}}"
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
                        @foreach ($activities_topics as $key=>$activity_topic)
                            @if($activity_topic['type']=="additional")
                                <li><a class="nav-link link-dark"
                                       id="activity_topic_{{$key}}"
                                       href="{{url('/area-activity/'.$activity_topic['id'])}}">{{$activity_topic['title_ua']}} </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" href="/masters" id="menu_masters"> Майстри </a>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item2" href="#"
               id="menu_studies"> Навчання <i
                    class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item2" class="submenu collapse" data-bs-parent="#nav_accordion">
                @foreach ($studies_topics as $key=>$study_topic)
                    <li><a class="nav-link link-dark"
                           id="study_topic_{{$key}}"
                           href="{{url("/studies/".$study_topic['id'])}}">{{$study_topic['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item_infos" href="#"
               id="menu_info"> Корисна інформація </a>
            <ul id="menu_item_infos" class="submenu collapse" data-bs-parent="#nav_accordion">
                @foreach ($infos as $key=>$info)
                    <li><a class="nav-link link-dark"
                           id="info_{{$key}}"
                           href="{{url("/infos-posts/".$info['id'])}}">{{$info['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item5" href="#"
               id="menu_events"> Події <i
                    class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item5" class="submenu collapse" data-bs-parent="#nav_accordion">
                @foreach ($events_topics as  $key=>$event_topic)
                    <li><a class="nav-link link-dark"
                           id="event_topic_{{$key}}"
                           href="{{url("/event-posts/".$event_topic['id'])}}">{{$event_topic['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @if (!auth()->check())
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'registration') active @endif"
                   href="{{url("/registration")}} "
                   type="submit" data-bs-toggle="modal" data-bs-target="#register" id="menu_register">Registration</a>
            </li>
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'login') active @endif" href="{{url("/login")}}"
                   type="submit" data-bs-toggle="modal" data-bs-target="#login" id="menu_login">Login</a>
            </li>
        @else
            <li class="nav-item link-secondary">
                <a class="nav-link link-dark @if(Request::segment(1) == 'logout') active @endif"
                   href="{{url("/logout")}} "
                   id="menu_logout"
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

                    <div class="form-group mb-3 d-flex flex-row div_form_social" style="">
                        <input type="text" class="form-control input_form input_form_social" readonly style=""
                               value="{{ old('social_type') }}" id="social_type" name="social_type"
                               placeholder="Оберіть соц. мережу">

                        <div class="element text-center"
                             style="border: none; border-radius: 10px 0 0 10px; background: white; width: 43px;">
                            <input type="radio" name="radio" class="switch-button" id="button1"
                                   onclick="insert2('Telegram')">
                            <label for="button1" style="border: none; border-radius: 10px 0 0 10px; width: 43px">
                                <img src="{{ URL("image/telegram.png")}}" class="switch-image"
                                     style="padding: 5px 5px 5px 5px;">
                            </label>
                        </div>
                        <div class="element text-center"
                             style="border: none; border-radius: 0 10px 10px 0; background: white; width: 43px;">
                            <input type="radio" name="radio" class="switch-button" id="button2"
                                   onclick="insert2('Viber')">
                            <label for="button2" style="border: none; border-radius: 0 10px 10px 0; width: 43px"><img
                                    src="{{ URL("image/viber.png")}}" class="switch-image"
                                    style="padding: 5px 6px 5px 4px;"></label>
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

                    @if($errors->any() && (!Session::has('login')|| !Session::get('login')))
                        <div class="text-center d-flex align-items-center justify-content-center" style="height: 40px">
                            <p style="font-size: 12px; color: red; margin-bottom: 0">{{$errors->first()}}</p>
                        </div>
                    @endif

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
                        @if($errors->any() && Session::has('login') && Session::get('login'))
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
                        <a type="button" onclick="exitLogin()" class="btn btn-primary form_sec_button col"
                           href="{{url("forget-password")}}" data-bs-toggle="modal" data-bs-target="#forget_password">Забули
                            пароль?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="forget_password" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true"
     style="backdrop-filter: blur(15px);">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content" style="background-color: #a9c6ff; border-radius: 25px; border: 0; margin: 0 20px">
            <div class="modal-header d-flex justify-content-center"
                 style="border: 0; margin: 18px 0; padding-bottom: 0">
                <p class="modal-title" id="exampleModalLongTitle" style="/*font-size: 30px;*/">Забули пароль?</p>
            </div>
            <div class="modal-body padding_for_form">
                <div class="card-body" style="padding: 0; margin-top: -10px">
                    <div>
                        <p class="text-center" style="font-size: 14px">На вказану вами пошту прийде лист для скидання
                            паролю. Якщо ви не побачите листа, то перевірте будь-ласка спам.</p>
                    </div>
                    @if (Session::has('message'))
                        <div class="alert alert-success" role="alert">
                            {{ Session::get('message') }}
                        </div>
                    @endif

                    <form action="{{ url('forget-password') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="form-group mb-3">
                                <input class="form-control input_form" type="text" id="email_address"
                                       value="{{old('email')}}" name="email" placeholder="Пошта" required autofocus>
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group mb-3">
                            <button style="cursor:pointer; margin: 0 0 -16px 0" type="submit"
                                    class="btn btn-primary form_main_button">Відправити
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function insert2(word) {
        document.getElementById("social_type").value = word;
    }

    @foreach ($activities_topics as $key=>$activity_topic)
    subscribeOnChangeLanguageCustomWords("#activity_topic_{{$key}}", "activity_topic_{{$key}}", {
        "ru": "{{$activity_topic["title_ru"]}}",
        "ua": "{{$activity_topic["title_ua"]}}",
    });
    @endforeach

    @foreach ($studies_topics as $key=>$study_topic)
    subscribeOnChangeLanguageCustomWords("#study_topic_{{$key}}", "study_topic_{{$key}}", {
        "ru": "{{$study_topic["title_ru"]}}",
        "ua": "{{$study_topic["title_ua"]}}",
    });
    @endforeach

    @foreach ($infos as $key=>$info)
    subscribeOnChangeLanguageCustomWords("#info_{{$key}}", "info_{{$key}}", {
        "ru": "{{$info["title_ru"]}}",
        "ua": "{{$info["title_ua"]}}",
    });
    @endforeach

    @foreach ($events_topics as $key=>$event_topic)
    subscribeOnChangeLanguageCustomWords("#event_topic_{{$key}}", "event_topic_{{$key}}", {
        "ru": "{{$event_topic["title_ru"]}}",
        "ua": "{{$event_topic["title_ua"]}}",
    });
    @endforeach
</script>
