@include('layouts.header')
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                @if (auth()->check())
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'accounts') active @endif"
                           href="{{url("/accounts")}}">Accounts</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'static') active @endif"
                           href="{{url("/static")}}">Static</a>
                    </li>
                @endif
            </ul>

            @if (!auth()->check())
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'registration') active @endif" href="{{url("/registration")}}"
                           type="submit">Registration</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'login') active @endif" href="{{url("/login")}}"
                           type="submit">Login</a>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link @if(Request::segment(1) == 'logout') active @endif" href="{{url("/logout")}}"
                           type="submit">Logout</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
</nav>
