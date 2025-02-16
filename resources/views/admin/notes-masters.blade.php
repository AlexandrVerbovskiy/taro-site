@extends('layouts.admin')
@section('content')
    <style>
        .btn-suc-dan{
            height: 30px;
            padding: 0 10px;
        }
        @media only screen and (max-width: 320px) {
            .btn-suc-dan{
                height: 24px;
                font-size: 12px;
                padding: 0 10px;
            }
        }
    </style>
    <div class="message-parent" style="padding: 8px">
        @include("layouts.error-message")
        <h3 class="text-center title_margin" style="margin: 24px 0">Записи до майстрів</h3>
        <div style="display: flex; justify-content: flex-end; margin: 20px 0 10px;">
            <input type="text" class="admin_search" name="search" placeholder="Search..."/>
            <a id="search" href="#"><img src="{{ URL("image/loupe.png")}}" class="admin_button_search align-middle"></a>
        </div>
        <div class="table table-responsive table-responsive-sm">
            <table class="table " style="width: 100%;">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" style="width: auto; min-width: 80px; max-width: 100px;">Study</th>
                    <th scope="col" style="">User</th>
                    <th scope="col" style="width: auto; min-width: 120px; max-width: 220px;">User phone</th>
                    <th scope="col" style="width: auto; min-width: 180px; max-width: 320px;">User email</th>
                    <th scope="col" style="width: auto; min-width: 180px; max-width: 320px;">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div class="loader hidden"></div>
    </div>

    <button id="reject-modal" style="display: none;">Reject</button>
    <button id="accept-modal" style="display: none;">Accept</button>

    <script>
        let showed = 0;
        const count = 20;
        let canShow = true;
        let trashId = null;
        let search = "";

        let actualModalId = null;

        const handleAcceptAccept = () => {
            post('{{url('/admin/note-to-master-accept')}}', {id: actualModalId}, res => {
                document.querySelector("tr[data-id='" + actualModalId + "'] td:has(.actions)").innerHTML = "<span style = 'color:green'>Accepted</span>"
                actualModalId = null;
            });
        }

        const handleRejectAccept = () => {
            post('{{url('/admin/note-to-master-reject')}}', {id: actualModalId}, res => {
                document.querySelector("tr[data-id='" + actualModalId + "'] td:has(.actions)").innerHTML = "<span style = 'color:red'>Rejected</span>"
                actualModalId = null;
            });

        }

        const handleAcceptClick = id => {
            actualModalId = id;
            document.querySelector("#accept-modal").click();
        }

        const handleRejectClick = id => {
            actualModalId = id;
            document.querySelector("#reject-modal").click();
        }

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

                console.log(data.notes);

                data.notes.forEach(note =>
                    rows += `
                       <tr data-id=${note["id"]}>
                        <th scope="row">${note["id"]}</th>
                        <td>${note["master_first_name"]} ${note["master_last_name"]}</td>
                        <td>${note["user_first_name"]} ${note["user_last_name"]}</td>
                        <td>${note["user_phone"]}</td>
                        <td>${note["user_email"]}</td>
                        <td>${note["status"] === "rejected" ?
                        "<span style = 'color:red'>Rejected</span>"
                        : (note["status"] === "accepted" ?
                            "<span style = 'color:green'>Accepted</span>" :
                            '<button onclick="handleAcceptClick('+note["id"]+')" class="btn btn-success btn-suc-dan actions">Accept</button>' +
                            '<button onclick="handleRejectClick('+note["id"]+')" class="btn btn-danger btn-suc-dan actions" style="margin-left: 5px">Reject</button>')}
                        </td></tr>`)
                document.querySelector(".table tbody").insertAdjacentHTML('beforeend', rows);
            });
        }

        document.querySelector("#search").addEventListener("click", () => {
            search = document.querySelector("input[name=search]").value;
            showed = 0;
            canShow = true;
            document.querySelector("table tbody").innerHTML = "";
            getNewNotes();
        })

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

        buildModal("danger", "Відхилення запиту на запис до майстра",
            "Ви впевнені, що хочете відхилити запит на запис до майстра?",
            document.querySelector("#reject-modal"), handleRejectAccept, "Прийняти");

        buildModal("success", "Прийняття запиту на запис до майстра",
            "Ви впевнені, що хочете прийняти запит на запис до майстра?",
            document.querySelector("#accept-modal"), handleAcceptAccept, "Прийняти");

    </script>
@stop
