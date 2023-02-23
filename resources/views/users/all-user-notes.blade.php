@include('layouts.main-header')

<h3 class="text-center title_margin" style="margin: 110px 0 30px">Записи</h3>

<div class="container">
    <div class="light-nav">
        <a class="btn btn-link @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-chief') active @endif"
           href="{{url('/user/notes-to-chief')}}">To chief</a>
        <a class="btn btn-link @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-masters') active @endif"
           href="{{url('/user/notes-to-masters')}}">To masters</a>
        <a class="btn btn-link @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-studies') active @endif"
           href="{{url('/user/notes-to-studies')}}">To studies</a>
    </div>

    <div class="light-table">
        @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-chief')
            <table>
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date sending</th>
                </tr>
                </thead>
                <tbody>
                @foreach($notes as $note)
                    <tr>
                        <th scope="col">{{$note->id}}</th>
                        <th scope="col">{{$note->date}}</th>
                        <th scope="col">{{$note->time}}</th>
                        <th scope="col" style="color: @if($note->status=="accepted") green @elseif($note->status=="rejected") red @else black @endif">{{$note->status}}</th>
                        <th scope="col">{{$note->created_at}}</th>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-studies')
                <table>
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date sending</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notes as $note)
                        <tr>
                            <th scope="col">{{$note->id}}</th>
                            <th scope="col">{{$note->study_title}}</th>
                            <th scope="col" style="color: @if($note->status=="accepted") green @elseif($note->status=="rejected") red @else black @endif">{{$note->status}}</th>
                            <th scope="col">{{$note->created_at}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

        @if(Request::segment(1) == 'user' && Request::segment(2) == 'notes-to-masters')
                <table>
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Master</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date sending</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($notes as $note)
                        <tr>
                            <th scope="col">{{$note->id}}</th>
                            <th scope="col">{{$note->master_first_name}} {{$note->master_last_name}}</th>
                            <th scope="col" style="color: @if($note->status=="accepted") green @elseif($note->status=="rejected") red @else black @endif">{{$note->status}}</th>
                            <th scope="col">{{$note->created_at}}</th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif

    </div>

</div>

@include('layouts.footer')
