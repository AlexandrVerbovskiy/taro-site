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
<header class="align-items-center" style="background-color: #a9c6ff; height: 80px; z-index: 10000000000">
    <div class="row align-items-center" style="width: 100%; margin: 0; height: 80px;">
        <div class="col">
            <div class="container-fluid d-flex justify-content-start" style="padding: 0px;">
                <a class="navbar-toggler collapsed d-flex flex-column justify-content-around link-dark text-decoration-none text-reset" type="button"
                   data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                   aria-expanded="false" aria-label="Toggle navigation">
                    <img class="img_menu" src="{{ URL("image/menu.png")}}">
                </a>
            </div>
        </div>
        <div class="col-5">
            <div class="bd-highlight text-center header_name" style="">Lorem ipsum chtototam text</div>
        </div>
        <div class="col d-flex justify-content-end">
            <a class="link-dark text-decoration-none lang_button">UA</a>
            <a class="link-dark text-decoration-none lang_button" style="margin-left: 20px">RUS</a>
        </div>
    </div>
</header>
<div class="collapse navbar-collapse" id="navbarNav" style="position: absolute; background-color: #a9c6ff; margin-top: 79px; width: 240px; box-shadow: 2px 2px 15px rgba(0, 0, 0, 0.25);">
    <ul class="nav flex-column" id="nav_accordion">
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item1" href="#"> Напрямки
                діяльності <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item1" class="submenu collapse" data-bs-parent="#nav_accordion">
                <li>
                    <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item3" href="#">
                        Основні <i class="bi small bi-caret-down-fill"></i> </a>
                    <ul id="menu_item3" class="submenu collapse" data-bs-parent="#menu_item1">
                        @foreach ($activities_topics as $activity_topic)
                            @if($activity_topic['title']=="basic")
                                <li><a class="nav-link link-dark"
                                       href="#{{$activity_topic['id']}}">{{$activity_topic['title_ua']}} </a>
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
                            @if($activity_topic['title']=="additional")
                                <li><a class="nav-link link-dark"
                                       href="#{{$activity_topic['id']}}">{{$activity_topic['title_ua']}} </a>
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
                    <li><a class="nav-link link-dark" href="#{{$study_topic['id']}}">{{$study_topic['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" href="#"> Корисна інформація </a>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item5" href="#"> Події <i
                    class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item5" class="submenu collapse" data-bs-parent="#nav_accordion">
                @foreach ($events_topics as $event_topic)
                    <li><a class="nav-link link-dark" href="#{{$event_topic['id']}}">{{$event_topic['title_ua']}} </a>
                    </li>
                @endforeach
            </ul>
        </li>
        @if (!auth()->check())
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'registration') active @endif" href="{{url("/registration")}} "
                   type="submit" data-bs-toggle="modal" data-bs-target="#register">Registration</a>
            </li>
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'login') active @endif" href="{{url("/login")}}"
                   type="submit" data-bs-toggle="modal" data-bs-target="#login">Login</a>
            </li>
        @else
            <li class="nav-item link-secondary">
                <a class="nav-link link-dark @if(Request::segment(1) == 'logout') active @endif" href="{{url("/logout")}} "
                   type="submit">Logout</a>
            </li>
        @endif
    </ul>
</div>
<!-- Modal -->
<div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="register" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Register</h5>
            </div>
            <form method="POST" action="{{url('/registration')}}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                        <label for="first_name">First name:</label>
                        <input type="text" class="form-control" value="{{ old('first_name') }}" id="first_name" name="first_name">
                    </div>

                    <div class="form-group mb-3">
                        <label for="last_name">Last name:</label>
                        <input type="text" class="form-control" value="{{ old('last_name') }}" id="last_name" name="last_name">
                    </div>

                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" value="{{ old('email') }}" id="email" name="email">
                    </div>

                    <div class="form-group mb-3">
                        <label for="phone">Phone:</label>
                        <input type="text" class="form-control" value="{{ old('phone') }}" id="phone" name="phone">
                    </div>

                    <div class="form-group mb-3">
                        <label for="social_type">Social type:</label>
                        <input type="text" class="form-control" value="{{ old('social_type') }}" id="social_type" name="social_type">
                    </div>

                    <div class="form-group mb-3">
                        <label for="social_phone">Social phone:</label>
                        <input type="text" class="form-control" value="{{ old('social_phone') }}" id="social_phone" name="social_phone">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>

                    <div class="form-group mb-3">
                        <label for="password_confirmation">Password Confirmation:</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation">
                    </div>

                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Login</h5>
            </div>
            <form method="POST" action="{{url('/login')}}">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="form-group mb-3">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" value="{{old('email')}}" name="email">
                    </div>
                    <div class="form-group mb-3">
                        <label for="password">Password:</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <a href="{{url("forget-password")}}">Forget password</a>
                    @if($errors->any())
                        <h4>{{$errors->first()}}</h4>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button style="cursor:pointer" type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>

