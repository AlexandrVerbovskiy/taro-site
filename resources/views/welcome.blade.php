@include('layouts.main-header')

<div class="row justify-content-center" style="width: 100%; margin: 0px">
    <div class="shapka text-center col-lg-8" style="padding: 0; ">
        <img class="" src="{{Storage::url("")}}images/{{$main_img}}" style="width: 100%; height: auto; margin-top: 80px">
    </div>
</div>

<h3 class="text-center" style=" margin: 20px;">Валерій</h3>
<div class="container main_text">
    {!! $main_body !!}
</div>


<div class="container text-center">
    @if (!auth()->check())
        <a type="button" class="btn btn-primary button_for_valera @if(Request::segment(1) == 'login') active @endif"
           href="{{url("/login")}}"
           type="submit" data-bs-toggle="modal" data-bs-target="#login">Увійти</a>
        <div class="d-flex flex-column">
            <div style="font-size: 12px; margin: 20px 0 60px">
                Запис доступний тільки після входу до акаунту на сайті, для цього натисніть на кнопку “Увійти”,
                якщо ви вперше на нашому сайті, то на сторінці входу ви зможете зареєструвати новий акаунт.
            </div>
        </div>

    @else
        @if(!$finded_note)
            <button type="button" class="btn btn-primary button_for_valera">Записатися</button>
            <div class="d-flex flex-column">
                <br>
                <div>Оберіть дату та час</div>
                <div>
                    Test 2
                </div>
            </div>
            @include("layouts.calendar", ["all"=>false, "dates"=>$dates])

            <div class="time-list"></div>

            <div class="container py-4 message-parent">
                @include("layouts.error-message")
            </div>
        @else
            @if($finded_note->status=="wait_accept")
                Ви вже відправили запит на підтвердженя на {{$finded_note->date}} {{$finded_note->time}}
            @else
                Ви вже записані на {{$finded_note->date}} {{$finded_note->time}}
            @endif
        @endif
    @endif
</div>

<script>

    @if(!$finded_note)
    function noteToBoss(id) {
        post("/note-to-boss",
            {
                time_id: id
            }, res => console.log(res));
    }

    const buildTimeRow = time => `
<div class="time-row" data-id="${time["id"]}">
    <div>Time:<b>${time['time']}</b></div>
    <button onclick="noteToBoss(${time["id"]})">Записатись</button>
</div>`;

    const onGetTimes=res=> {
        if (res.error) return;
        res.times.forEach(time => document.querySelector(".time-list").insertAdjacentHTML("beforeend", buildTimeRow(time)));
    }

    buildCalendar((e)=>get("/calendar-times/" + e.target.dataset.date, res => onGetTimes(res)));

    @endif
</script>

@include('layouts.footer')
