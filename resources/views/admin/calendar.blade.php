@extends('layouts.admin')
@section('content')
    <div class=" message-parent" style="margin: 0; padding: 0">
        <h3 class="text-center title_margin" style="margin: 24px 0 0">Календар</h3>
        @include("layouts.error-message")
        @include("layouts.calendar", ["all"=>true])
        <div>

            <div class="" style="margin-top: 20px;">
                <div class="row ">
                    <div class="col-md-6 mx-auto">
                        <div class="time-list text-center" style="margin-bottom: 40px">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <button id="trash-modal" style="display: none;">Trash</button>

    <script>
        const acceptDelete = () => {
            post('{{url('/admin/calendar-time-delete')}}', {id: trashId}, res => {
                document.querySelector(`.time-row[data-id='${trashId}']`).remove();
            });
        }

        const reject = (id) => {
            post('{{url('/admin/note-to-boss-reject')}}', {id}, res => {
                console.log(res);
            });
        }

        const accept = (id) => {
            post('{{url('/admin/note-to-boss-accept')}}', {id}, res => {
                console.log(res);
            });
        }

        const buildTimeRow = time => `
                <div class="time-row" data-id="${time["id"]}">
                    <div>Час: <b>${time['time'].slice(0,5)}</b></div>
                    ${time["first_name"]?
                    `<div>Клієнт: ${time["first_name"]} ${time["last_name"]}</div>
                        <div>Телефон: ${time["phone"]}</div>
                        <button class="btn btn-success admin_button_SaniaZaebalEdition" onclick="accept(${time["id"]})">Погодити</button>
                        <button class="btn btn-danger admin_button_SaniaZaebalEdition" onclick="reject(${time["id"]})">Відхилити</button>
                       `:""}
                    <button type="button" class="btn trash btn-danger admin_button_SaniaZaebalEdition" data-id="${time["id"]}" onclick="handleTrashClick(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash admin_button_img_SaniaZaebalEdition" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                        </button>
                </div><hr>`;



        const handleTrashClick = (e) => {
            if (e.tagName != "BUTTON") e = e.closest('button');
            trashId = e.dataset.id;
            document.querySelector("#trash-modal").click();
        }

        const onGetTimes=res=>
        {
            const timeParent = document.querySelector(".time-list");
            res.times.forEach(time => timeParent.insertAdjacentHTML("beforeend", buildTimeRow(time)));
            timeParent.insertAdjacentHTML("afterbegin", `
                <h4>Новий час</h4><input type="time" id="time" min="00:00" max="23:59" class="input_calendar_add_time"><button id="add_time" class="appointment_button_add_time">Додати</button><h4>Записи</h4>

            `)

            document.querySelector("#add_time").addEventListener("click", e => {
                const value = document.querySelector("#time").value;
                if (!value) return;
                post("/admin/calendar-time-edit", {
                    time: value,
                    date: res.date
                }, res => {
                    if (res.error) return;
                    document.querySelector("#time").value = "";
                    document.querySelector("#add_time").insertAdjacentHTML("afterend", buildTimeRow(res.data));
                });
            })
        }

        buildCalendar((e)=>get("/admin/calendar-times/" + e.target.dataset.date, res => onGetTimes(res)));

        buildModal("danger", "Removing the master", "Ви точно хочете видалити час запису?", document.querySelector("#trash-modal"), acceptDelete);

    </script>
@stop
