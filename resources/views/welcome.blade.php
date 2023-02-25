@include('layouts.main-header')

<div class="row justify-content-center" style="width: 100%; margin: 0px">
    <div class="shapka text-center col-lg-8" style="padding: 0; ">
        <img class="" src="{{Storage::url("")}}images/{{$main_img}}"
             style="width: 100%; height: auto; margin-top: 80px">
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
        <!--<button type="button" class="btn btn-primary button_for_valera">Записатися</button>-->
            <h4 class="text-center" style=" margin: 20px 0;">Запис</h4>
            <div class="d-flex flex-column">
                <div>Оберіть дату та час</div>
                <div>
                    Доступні дати виділені синім, після натискання будуть відображені години для запису.
                </div>
            </div>
            @include("layouts.calendar", ["all"=>false, "dates"=>$dates])
            <h5 style="margin: 20px 0">Доступні години запису:</h5>
            <div class="time-list"></div>

            <div class="container py-4 message-parent">
                @include("layouts.error-message")
            </div>
        @else
            @if($finded_note->status=="wait_accept")
                <div style="margin: 8px 0 36px">Ви вже відправили запит на підтвердженя на {{$finded_note->date}} {{$finded_note->time}}</div>
            @else
                <div style="margin: 8px 0 36px">Ви вже записані на {{$finded_note->date}} {{$finded_note->time}}</div>
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

    const buildTimeRow = time => {
        console.log(time);
        return `
<div class="time-row" data-id="${time["id"]}">
    <div>Час: <b>${time['time'].slice(0, 5)}</b><button class="appointment_button" onclick="noteToBoss(${time["id"]})" style="">Записатись</button></div>

</div>`;
    }

    const onGetTimes = res => {
        if (res.error) return;
        res.times.forEach(time => document.querySelector(".time-list").insertAdjacentHTML("beforeend", buildTimeRow(time)));
    }

    if (document.querySelector(".calendar")) buildCalendar((e) => get("/calendar-times/" + e.target.dataset.date, res => onGetTimes(res)));

    @endif
</script>

@include('layouts.footer')
