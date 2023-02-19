@extends('layouts.admin')
@section('content')
    <div class="container py-4 message-parent">
        @include("layouts.error-message")
        <div>
            @include("layouts.calendar")
        </div>
    </div>

    <div class="time-list">

    </div>

    <script>
        buildCalendar(res=>{
            const timeParent = document.querySelector(".time-list");
            timeParent.innerHTML="";
            console.log(res);
            timeParent.insertAdjacentHTML("beforeend", `
                <button>New time</button>
            `)
        })
    </script>
@stop
