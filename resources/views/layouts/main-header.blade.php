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
<header class="align-items-center" style="background-color: #a9c6ff; height: 80px; z-index: 10; width: 100%; position: fixed">
    <div class="row align-items-center" style="width: 100%; margin: 0; height: 80px; ">
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
            <div class="bd-highlight  text-center " style="">
                <a class="link-dark header_name"href="/">
                    Lorem ipsum chtototam text</a>

            </div>
        </div>
        <div class="col d-flex justify-content-end">
            <a class="link-dark text-decoration-none lang_button">UA</a>
            <a class="link-dark text-decoration-none lang_button" style="margin-left: 20px">RUS</a>
        </div>
    </div>
</header>
@include('layouts.menu')


