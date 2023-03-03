@include('layouts.main-header')
<div style="height: 80px"></div>
<div class="row justify-content-center" style="width: 100%; height: auto; max-height: 450px; margin: 0">
    <div class="shapka text-center col-lg-8" style="padding: 0; ">
        <img class="" src="{{Storage::url("")}}images/{{$main_img}}"
             style="width: 100%; height: inherit; max-height: 450px; object-fit: contain; /*margin-top: 80px*/">
    </div>

</div>

<h3 class="text-center welcome_name" style="position: relative; margin: 20px;">Валерій</h3>
<div class="container main_text" style="padding: 12px">
    {!! $main_body !!}
</div>
<div class="container text-center">
    @if (!auth()->check())
        <a type="button" class="btn btn-primary button_for_valera welcome_login @if(Request::segment(1) == 'login') active @endif"
           href="{{url("/login")}}"
           type="submit" data-bs-toggle="modal" data-bs-target="#login">Увійти</a>
        <div class="d-flex flex-column">
            <div style="font-size: 12px; margin: 20px 0 60px" class="welcome_login_text">
                Запис доступний тільки після входу до акаунту на сайті, для цього натисніть на кнопку “Увійти”,
                якщо ви вперше на нашому сайті, то на сторінці входу ви зможете зареєструвати новий акаунт.
            </div>
        </div>

    @else
        @if(!$finded_note)
        <!--<button type="button" class="btn btn-primary button_for_valera">Записатися</button>-->
            <h4 class="text-center" style=" margin: 20px 0;">Запис</h4>
            <div class="d-flex flex-column">
                <div class="welcome_text_one">Оберіть дату та час</div>
                <div class="welcome_text_two">
                    Доступні дати виділені голубим, після натискання будуть відображені години для запису.
                </div>
            </div>
            @include("layouts.calendar", ["all"=>false, "dates"=>$dates])

            <div class="time-list"></div>

            <div class="container py-4 message-parent">
                @include("layouts.error-message")
            </div>
        @else
            @if($finded_note->status=="wait_accept")
                <div style="margin: 8px 0 36px">Ви вже відправили запит на підтвердженя
                    на <b>{{$finded_note->date}} {{$finded_note->time}}</b></div>
            @else
                <div style="margin: 8px 0 36px">Ви вже записані на <b>{{$finded_note->date}} {{$finded_note->time}}</b></div>
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
            }, res => {
                if (res.error) {
                    if (!res.status) return;

                    const lang = getLang();
                    if (res.status == -2) {
                        showError(vocabulary['error_chief_note']["-2_p1"][lang] + res.date + vocabulary['error_chief_note']["-2_p2"][lang]);
                    } else {
                        showError(vocabulary['error_chief_note'][res.status][lang]);
                    }
                } else {
                    showSuccess(vocabulary['success_chief_note'][lang]);
                }
            }, true, true);
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
        if(res.times.length > 0){
            console.log(res.times)
            document.querySelector(".time-list").insertAdjacentHTML("afterbegin", `
                <h5 style="margin: 20px 0">Доступні години запису:</h5>`)
        }
        res.times.forEach(time => document.querySelector(".time-list").insertAdjacentHTML("beforeend", buildTimeRow(time)));
    }

    if (document.querySelector(".calendar")) buildCalendar((e) => get("/calendar-times/" + e.target.dataset.date, res => onGetTimes(res)));

    @endif

    subscribeOnChangeLanguage('.welcome_name', 'welcome_name');
    if (document.querySelector('.welcome_login')) {
        subscribeOnChangeLanguage('.welcome_login', 'welcome_login');
        subscribeOnChangeLanguage('.welcome_login_text', 'welcome_login_text');
    }
    else {
        if (document.querySelector('.welcome_enrol')) {
            subscribeOnChangeLanguage('.welcome_text_one', 'welcome_text_one');
            subscribeOnChangeLanguage('.welcome_text_two', 'welcome_text_two');
            // subscribeOnChangeLanguage('.welcome_hours_available', 'welcome_hours_available');
        }
    }
</script>
@include('layouts.footer')









