@extends('layouts.admin')
@section('content')
    <div class="container">
        <h3 class="text-center title_margin" style="margin: 30px 0 30px">Події</h3>
        <div style="display: flex; justify-content: flex-end; margin: 20px 0 10px;">
            <a href="{{url("/admin/create-event")}}" class="btn btn-primary admin_button_add">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="bi bi-pencil admin_add_img" viewBox="0 0 16 16">
                    <path
                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                </svg>
                Add
            </a>
            <input type="text" class="admin_search" name="search" placeholder="Search..."/>
            <a id="search" href="#"><img src="{{ URL("image/loupe.png")}}" class="admin_button_search align-middle"></a>
        </div>
        <div class="table table-responsive table-responsive-sm scroll_table">
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Master</th>
                    <th scope="col">User</th>
                    <th scope="col">User phone</th>
                    <th scope="col">User email</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="loader hidden"></div>
    </div>

    <script>
        let showed = 0;
        const count = 20;
        let canShow = true;
        let trashId = null;
        let search = "";

        document.querySelector("#search").addEventListener("click", () => {
            search = document.querySelector("input[name=search]").value;
            showed = 0;
            document.querySelector("table tbody").innerHTML = "";
            getNewEvents();
        })


        const getNewNotes = () => {
            document.querySelector(".loader").classList.remove('hidden');
            if (!canShow) return document.querySelector(".loader").classList.add('hidden');
            post("{{url('/admin/get-notes-to-masters')}}", {
                start: showed,
                count,
                search
            }, data => {
                document.querySelector(".loader").classList.add('hidden');
                if (data.error) return canShow = false;

                let rows = "";
                showed += data.notes.length;
                if (data.notes.length != count) canShow = false;

                data.notes.forEach(note =>
                    rows += `
                       <tr data-id=${note["id"]}>
                        <th scope="row">${note["id"]}</th>
                        <td>${note["master_first_name"]} ${note["master_last_name"]}</td>
                        <td>${note["user_first_name"]} ${note["user_last_name"]}</td>
                        <td>${note["user_phone"]}</td>
                        <td>${note["user_email"]}</td>
                        <td></td>
                    </tr>`)
                document.querySelector(".table tbody").insertAdjacentHTML('beforeend', rows);
            });
        }

        getNewNotes();

        $(document).ready(function () {
            var windowHeight = $(window).height();
            $(document).on('scroll', function () {
                $('.loader').each(function () {
                    var self = $(this),
                        height = self.offset().top + self.height();
                    if ($(document).scrollTop() + windowHeight >= height) {
                        if (self.hasClass('hidden')) {
                            getNewNotes();
                        }
                    }
                });
            });
        });

    </script>
@stop
