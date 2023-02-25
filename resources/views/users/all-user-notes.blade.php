@include('layouts.main-header')

<h3 class="text-center title_margin" style="margin: 110px 0 30px">Записи</h3>

<div class="container">
    <div class="light-nav text-center">
        <a class="btn btn-primary appointment_button_menu @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-chief') active @endif"
           href="{{url('/user/notes-to-chief')}}">До Валерія</a>
        <a class="btn btn-primary appointment_button_menu @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-masters') active @endif"
           href="{{url('/user/notes-to-masters')}}">До майстрів</a>
        <a class="btn btn-primary appointment_button_menu @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-studies') active @endif"
           href="{{url('/user/notes-to-studies')}}">На навчання</a>
    </div>

    <div class="table table-responsive table-responsive-sm">
        @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-chief')
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Дата запису</th>
                    <th scope="col">Час</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата відправленя</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notes as $note)
                    <tr>
                        <th scope="col">{{$note->id}}</th>
                        <th scope="col" style="min-width: 100px;">{{$note->date}}</th>
                        <th scope="col">{{$note->time}}</th>
                        <th scope="col" style="color: @if($note->status=="accepted") green @elseif($note->status=="rejected") red @else black @endif">{{$note->status}}</th>
                        <th scope="col" style="min-width: 120px">{{$note->created_at}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-studies')
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Заголовок</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата відправлення</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notes as $note)
                    <tr>
                        <th scope="col">{{$note->id}}</th>
                        <th scope="col">{{$note->study_title}}</th>
                        <th scope="col" style="color: @if($note->status=="accepted") green @elseif($note->status=="rejected") red @else black @endif">{{$note->status}}</th>
                        <th scope="col" style="min-width: 120px">{{$note->created_at}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-masters')
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Майстер</th>
                    <th scope="col">Статус</th>
                    <th scope="col">Дата відправлення</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notes as $note)
                    <tr>
                        <th scope="col">{{$note->id}}</th>
                        <th scope="col">{{$note->master_first_name}} {{$note->master_last_name}}</th>
                        <th scope="col" style="color: @if($note->status=="accepted") green @elseif($note->status=="rejected") red @else black @endif">{{$note->status}}</th>
                        <th scope="col" style="min-width: 120px">{{$note->created_at}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
</div>

@include('layouts.footer')
