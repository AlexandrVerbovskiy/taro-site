@include('layouts.header')
<header class="d-flex justify-content-between align-items-center" style="background-color: #a9c6ff; height: 70px;">
    <div class="p-2">
        <div class="container-fluid">
            <button class="navbar-toggler collapsed d-flex flex-column justify-content-around" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon">B</span>
            </button>
        </div>
    </div>
    <div class="p-2 bd-highlight">HOME</div>
    <div class="p-2 bd-highlight">LANG</div>
</header>
<div class="collapse navbar-collapse" id="navbarNav" style="position: fixed; background-color: #a9c6ff;">
    <ul class="nav flex-column" id="nav_accordion">
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item1" href="#"> Напрямки
                діяльності <i class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item1" class="submenu collapse" data-bs-parent="#nav_accordion">
                <li>
                    <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item3" href="#">
                        Основні <i class="bi small bi-caret-down-fill"></i> </a>
                    <ul id="menu_item3" class="submenu collapse" data-bs-parent="#menu_item1">

                    </ul>
                </li>
                <li>
                    <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item4" href="#">
                        Додаткові <i class="bi small bi-caret-down-fill"></i> </a>
                    <ul id="menu_item4" class="submenu collapse" data-bs-parent="#menu_item1">

                    </ul>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" href="#"> Майстри </a>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item2" href="#"> Навчання <i
                    class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item2" class="submenu collapse" data-bs-parent="#nav_accordion">

            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" href="#"> Корисна інформація </a>
        </li>
        <li class="nav-item">
            <a class="nav-link link-dark" data-bs-toggle="collapse" data-bs-target="#menu_item5" href="#"> Події <i
                    class="bi small bi-caret-down-fill"></i> </a>
            <ul id="menu_item5" class="submenu collapse" data-bs-parent="#nav_accordion">

            </ul>
        </li>
        @if (!auth()->check())
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'registration') active @endif" href="{{url("/registration")}}"
                   type="submit">Registration</a>
            </li>
            <li class="nav-item link-dark">
                <a class="nav-link link-dark @if(Request::segment(1) == 'login') active @endif" href="{{url("/login")}}"
                   type="submit">Login</a>
            </li>
        @else
            <li class="nav-item link-secondary">
                <a class="nav-link link-dark @if(Request::segment(1) == 'logout') active @endif" href="{{url("/logout")}}"
                   type="submit">Logout</a>
            </li>
        @endif
    </ul>
</div>

