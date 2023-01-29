<div>
    <input type="date" id="date">
    <button id="create_date">Create date</button>
    <div id="dates"></div>
</div>

<div>
    <input type="time" id="time">
    <button id="create_time">Create time</button>
    <div id="times"></div>
</div>


<script>
    const dateButton = date => `<button data-id='` + date['id'] + `'>` + date['date'] + `</button>`;
    const timeButton = time => `<button data-id='` + time['id'] + `'>` + time['time'] + `</button>`;

    let times = [];

    let selectedDateId = null;
    const dateBtnClick = e => {
        document.querySelector("#times").innerHTML="";
        const dataId = e.target.dataset.id;
        if (dataId == selectedDateId) return;

        selectedDateId = dataId;
        fetch('{{url('/calendar-times')}}/' + selectedDateId, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': <?=json_encode(csrf_token())?>
            },
            method: 'GET'
        }).then(res => res.json()).then(data => {
           data.forEach(onAddTime)
        });
    }

    const onAddDate = date => {
        document.querySelector("#dates").insertAdjacentHTML('afterbegin', dateButton(date));
        document.querySelectorAll("#dates button")[0].addEventListener('click', dateBtnClick);
    }

    const onAddTime = time=>{
        document.querySelector("#times").insertAdjacentHTML('afterbegin', timeButton(time));
    }

    const dates = JSON.parse('{{ json_encode($dates) }}'.replace(/&quot;/g, '"'));
    dates.forEach(onAddDate);
    document.querySelectorAll("#dates button")[0].click();

    document.querySelector('#create_date').addEventListener('click', function () {

        const date = document.querySelector("#date").value;
        if (!date) return;

        fetch('{{url('/calendar-date-edit')}}', {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': <?=json_encode(csrf_token())?>
            },
            method: 'POST',
            body: JSON.stringify({
                date
            })
        }).then(res => res.json()).then(data => {
            onAddDate(data.data);
            document.querySelectorAll("#dates button")[0].click();
        });
    });

    document.querySelector('#create_time').addEventListener('click', function () {
        if (!selectedDateId) return alert("date doesn't select");

        const time = document.querySelector("#time").value;
        if (!time) return;

        fetch('{{url('/calendar-time-edit')}}', {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': <?=json_encode(csrf_token())?>
            },
            method: 'POST',
            body: JSON.stringify({
                time,
                calendar_date_id: selectedDateId
            })
        }).then(res => res.json()).then(data => {
            onAddTime(data.data);
        });
    });
</script>
