@include('layouts.header')
<div class="container">
    <nav class="navbar navbar-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler collapsed d-flex flex-column justify-content-around" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav"
                    aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav flex-column" id="nav_accordion">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#menu_item1" href="#"> Напрямки
                            діяльності <i class="bi small bi-caret-down-fill"></i> </a>
                        <ul id="menu_item1" class="submenu collapse" data-bs-parent="#nav_accordion">
                            <li>
                                <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#menu_item3" href="#">
                                    Основні <i class="bi small bi-caret-down-fill"></i> </a>
                                <ul id="menu_item3" class="submenu collapse" data-bs-parent="#menu_item1">
                                    @foreach ($activities_topics as $activity_topic)
                                        @if($activity_topic['title']=="basic")
                                            <li><a class="nav-link"
                                                   href="#{{$activity_topic['id']}}">{{$activity_topic['title_ua']}} </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                            <li>
                                <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#menu_item4" href="#">
                                    Додаткові <i class="bi small bi-caret-down-fill"></i> </a>
                                <ul id="menu_item4" class="submenu collapse" data-bs-parent="#menu_item1">
                                    @foreach ($activities_topics as $activity_topic)
                                        @if($activity_topic['title']=="additional")
                                            <li><a class="nav-link"
                                                   href="#{{$activity_topic['id']}}">{{$activity_topic['title_ua']}} </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Майстри </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#menu_item2" href="#"> Навчання <i
                                class="bi small bi-caret-down-fill"></i> </a>
                        <ul id="menu_item2" class="submenu collapse" data-bs-parent="#nav_accordion">
                            @foreach ($studies_topics as $study_topic)
                                <li><a class="nav-link" href="#{{$study_topic['id']}}">{{$study_topic['title_ua']}} </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#"> Корисна інформація </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" data-bs-target="#menu_item5" href="#"> Події <i
                                class="bi small bi-caret-down-fill"></i> </a>
                        <ul id="menu_item5" class="submenu collapse" data-bs-parent="#nav_accordion">
                            @foreach ($events_topics as $event_topic)
                                <li><a class="nav-link" href="#{{$event_topic['id']}}">{{$event_topic['title_ua']}} </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>
