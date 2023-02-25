@extends('layouts.admin')
@section('content')
    <div class="container">
        <h3 class="text-center title_margin" style="margin: 24px 0">Коментарі до майстрів</h3>
        <div style="display: flex; justify-content: flex-end; margin: 20px 0 10px;">
            <input type="text" class="admin_search" name="search" placeholder="Search..."/>
            <a id="search" href="#"><img src="{{ URL("image/loupe.png")}}" class="admin_button_search align-middle"></a>
        </div>
        <div class="table table-responsive table-responsive-sm" style="">
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Master</th>
                    <th scope="col">Author</th>
                    <th scope="col">Body</th>
                    <th scope="col">Actions</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>

        </div>
        <div class="loader hidden"></div>
    </div>
    <button id="trash-modal" style="display: none;">Trash</button>
    <script>
        let trashId = null;
        let showed = 0;
        const count = 20;
        let canShow = true;
        let search = "";

        document.querySelector("#search").addEventListener("click", () => {
            search = document.querySelector("input[name=search]").value;
            showed = 0;
            canShow = true;
            document.querySelector("table tbody").innerHTML="";
            getComments();
        })

        const getComments= () => {
            if (!canShow) return;
            document.querySelector(".loader").classList.remove('hidden');
            get("{{url('/admin/get-comments')}}" + "?start=" + showed + "&count=" + count+"&search="+search, data => {
                document.querySelector(".loader").classList.add('hidden');
                if (data.error) return canShow = false;
                if(data.comments.length != count) canShow = false;

                let rows = "";
                showed += data.comments.length;
                data.comments.forEach(comment =>
                    rows += `
                       <tr data-id=${comment["id"]}>
                        <th scope="row">${comment["id"]}</th>
                        <td scope="row">${comment["master_first_name"]+" "+comment["master_last_name"]}</td>
                        <td>${comment["user_first_name"]+" "+comment["user_last_name"]}</td>
                        <td>${comment["body"]}</td>
                        <td>
                        <button type="button" class="btn trash btn-danger" data-id="${comment["id"]}" onclick="handleTrashClick(this)">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                        </button>
                        </td>
                    </tr>`)
                document.querySelector(".table tbody").insertAdjacentHTML('beforeend', rows);
            });
        }

        getComments();

        const acceptDelete = () => {
            post('{{url('/admin/master-comment-delete')}}', {id: trashId}, res => {
                document.querySelector(`tr[data-id='${trashId}']`).remove();
            });
        }

        const handleTrashClick = (e) => {
            trashId = btnFromEvent(e).dataset.id;
            document.querySelector("#trash-modal").click();
        }

        $(document).ready(function () {
            var windowHeight = $(window).height();
            $(document).on('scroll', function () {
                $('.loader').each(function () {
                    var self = $(this),
                        height = self.offset().top + self.height();
                    if ($(document).scrollTop() + windowHeight >= height) {
                        if (self.hasClass('hidden')) {
                            getComments();
                        }
                    }
                });
            });
        });

        document.querySelectorAll(".trash").forEach(trash => trash.addEventListener("click", handleTrashClick));

        buildModal("danger", "Removing the master", "Are you sure you want to remove the wizard?", document.querySelector("#trash-modal"), acceptDelete);
    </script>
@stop
