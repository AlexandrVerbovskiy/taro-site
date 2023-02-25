@php
    if(!isset($all)) $all = false;
    if(!isset($dates)) $dates = [];
@endphp

<style>
    .calendar {
        width: 100%;
        max-width: 400px;
        background-color: #fff;
        border-radius: 10px;
        padding: 20px;
        margin-top: 30px;
        box-shadow: 0 0 10px 2px rgba(0, 0, 0, 0.1);
    }

    .calendar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        width: 100%;
    }

    .calendar-weekdays {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .calendar-weekday {
        font-weight: bold;
    }

    .calendar-day {
        text-align: center;
        padding: 10px 0;
        cursor: pointer;
    }

    .calendar-day:hover {
        background-color: #f1f1f1;
    }

    .calendar-day.active {
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
    }

    @if(!$all)
    .calendar-day:not(.active) {
        color: #dadada;
        cursor: default;
    }

    @endif

    .calendar-days {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        margin-bottom: 10px;
    }

    .calendar-day {
        text-align: center;
        padding: 5px;
        margin: 0 2px 5px;
        border-radius: 5px;
        cursor: pointer;
    }

    .calendar-day:hover {
        background-color: #f2f2f2;
    }

    .calendar-day.active {
        background-color: #a9c6ff;
        color: white;
    }

    .calendar-day.selected {
        background-color: #0d6efd;
        color: white;
    }

    .calendar-day.disabled {
        color: #bbb;
    }
    .button_calendar{
        background-color: #a9c6ff;
        border: 0;
    }
    .button_calendar::selection{
        background-color: #0d6efd;
        color: white;
    }
    @media (max-width: 768px) {
        .calendar {
            max-width: 100%;
        }
    }
    @media (max-width: 320px) {
        #calendar-month-year{
            font-size: 16px;
        }
        .button_calendar{
            font-size: 12px;
        }
        .calendar-weekdays{
            font-size: 12px;
        }
        .calendar-days{
            font-size: 12px;
        }
    }
</style>

<div class="container">
    <div class="row" style="display: flex; justify-content: center;">
        <div class="calendar">
            <div class="calendar-header">
                <button class="btn btn-primary float-start button_calendar" id="previous-month">&lt;</button>
                <h5 id="calendar-month-year" style="margin: 0"></h5>
                <button class="btn btn-primary float-end button_calendar" id="next-month">&gt;</button>
            </div>
            <div class="calendar-weekdays"></div>
            <div class="calendar-days"></div>
        </div>
    </div>
</div>

<script>
    function buildCalendar(onClick) {
        const calendar = {
            init: function () {
                this.date = new Date();
                this.month = this.date.getMonth();
                this.year = this.date.getFullYear();
                this.days = [];
                this.activeDates = @json($dates);
                this.render();
                this.listeners();
            },

            render: function () {
                const firstDayOfMonth = new Date(this.year, this.month, 1);
                const lastDayOfMonth = new Date(this.year, this.month + 1, 0);
                const lastDayOfPreviousMonth = new Date(this.year, this.month, 0);

                const monthYear = document.getElementById('calendar-month-year');
                monthYear.innerHTML = this.getMonthName(this.month) + ' ' + this.year;

                const weekdays = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
                const weekdaysEl = document.querySelector('.calendar-weekdays');
                weekdaysEl.innerHTML = '';
                weekdays.forEach(function (day) {
                    const weekdayEl = document.createElement('div');
                    weekdayEl.classList.add('calendar-weekday');
                    weekdayEl.innerHTML = day;
                    weekdaysEl.appendChild(weekdayEl);
                });

                const daysEl = document.querySelector('.calendar-days');
                daysEl.innerHTML = '';

                // Add previous month days
                for (let i = lastDayOfPreviousMonth.getDate() - firstDayOfMonth.getDay() + 1; i <= lastDayOfPreviousMonth.getDate(); i++) {
                    const dayEl = document.createElement('div');
                    dayEl.classList.add('calendar-day', 'disabled');
                    dayEl.innerHTML = i;
                    daysEl.appendChild(dayEl);
                }

                // Add current month days
                for (let i = 1; i <= lastDayOfMonth.getDate(); i++) {
                    const dayEl = document.createElement('div');
                    dayEl.classList.add('calendar-day');
                    if (this.activeDates.includes(`${this.year}-${this.padMonth(this.month + 1)}-${this.padDay(i)}`)) {
                        dayEl.classList.add('active');
                    }
                    dayEl.dataset.date = `${this.year}-${this.padMonth(this.month + 1)}-${this.padDay(i)}`;
                    dayEl.innerHTML = i;
                    daysEl.appendChild(dayEl);
                }

                // Add next month days
                const nextMonthDaysCount = 7 - (daysEl.children.length % 7);
                for (let i = 1; i <= nextMonthDaysCount; i++) {
                    const dayEl = document.createElement('div');
                    dayEl.classList.add('calendar-day', 'disabled');
                    dayEl.innerHTML = i;
                    daysEl.appendChild(dayEl);
                }
            },

            listeners: function () {
                const previousMonthButton = document.getElementById('previous-month');
                const nextMonthButton = document.getElementById('next-month');
                const calendarDays = document.querySelector('.calendar-days');

                previousMonthButton.addEventListener('click', () => {
                    this.month--;
                    if (this.month < 0) {
                        this.month = 11;
                        this.year--
                    }
                    this.render();
                });

                nextMonthButton.addEventListener('click', () => {
                    this.month++;
                    if (this.month > 11) {
                        this.month = 0;
                        this.year++;
                    }
                    this.render();
                });

                calendarDays.addEventListener('click', (event) => {
                    const dayEl = event.target;
                    if (dayEl.classList.contains('disabled')) return;

                    @if(!$all)
                    if (!dayEl.classList.contains('active')) return;
                    @endif

                    const findElem = document.querySelector(".selected");
                    if (findElem == dayEl) return;

                    if (findElem) findElem.classList.remove("selected");
                    const selectedDate = new Date(this.year, this.month, dayEl.innerHTML);
                    dayEl.classList.add("selected");
                    document.querySelector(".time-list").innerHTML = "";
                    onClick(event);
                });
            },

            getMonthName: function (month) {
                const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                return monthNames[month];
            },

            padMonth: function (month) {
                return String(month).padStart(2, '0');
            },

            padDay: function (day) {
                return String(day).padStart(2, '0');
            },
        };
        calendar.init();
    }
</script>
