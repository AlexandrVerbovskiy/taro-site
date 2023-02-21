@extends('layouts.admin')
@section('content')
    <div class="container">
        <h3 class="text-center title_margin" style="margin: 86px 0 30px">Навчання</h3>
        <div style="display: flex; justify-content: flex-end; margin: 20px 0 10px;">
            <a href="{{url("/admin/create-study")}}" class="btn btn-primary admin_button_add">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="bi bi-pencil admin_add_img" viewBox="0 0 16 16">
                    <path
                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                </svg>
                Додати
            </a>
            <input type="text" class="admin_search" name="search" placeholder="Search..."/>
            <a id="search" href="#"><img src="{{ URL("image/loupe.png")}}" class="admin_button_search align-middle"></a>
        </div>
        <div class="table table-responsive table-responsive-sm">
            <table class="table admin_3_table_sm">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col" style="min-width: 150px;">Title</th>
                    <th scope="col" style="width: 160px;">Actions</th>
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
        let showed = 0;
        const count = 20;
        let canShow = {{$count}}>0;
        let trashId = null;
        let search = "";

        document.querySelector("#search").addEventListener("click", () => {
            search = document.querySelector("input[name=search]").value;
            showed = 0;
            document.querySelector("table tbody").innerHTML="";
            getNewStudies();
        })

        const acceptDelete = () => {
            console.log(trashId);
            post('{{url('/admin/study-delete')}}', {id: trashId}, res => {
                console.log(`tr[data-id='${trashId}']`)
                document.querySelector(`tr[data-id='${trashId}']`).remove();
                console.log(res)
            });
        }

        const handleTrashClick = (e) => {
            trashId = e.dataset.id;
            document.querySelector("#trash-modal").click();
        }

        const handleChangeVisibleClick = (e) => {
            const id = e.dataset.id;
            post('{{url('/admin/study-change-visible')}}', {id}, res => {
                if (res.error) return;
                if(res.hidden){
                    e.classList.add("btn-danger");
                    e.classList.remove("btn-success");
                }else{
                    e.classList.remove("btn-danger");
                    e.classList.add("btn-success");
                }
            });
        }

        const getNewStudies = () => {
            console.log(showed, count)
            document.querySelector(".loader").classList.remove('hidden');
            if (!canShow) return document.querySelector(".loader").classList.add('hidden');
            get("{{url('/admin/get-studies')}}" + "?start=" + showed + "&count=" + count+"&search="+search, data => {
                document.querySelector(".loader").classList.add('hidden');
                if (data.error) return canShow = false;
                if(data.studies.length != count) canShow = false;

                let rows = "";
                showed += data.studies.length;
                data.studies.forEach(study =>
                    rows += `
                       <tr data-id=${study["id"]}>
                        <th scope="row">${study["id"]}</th>
                        <td>${study["title"]}</td>
                        <td>${getBtns('{{url("/admin/edit-study")}}', study["id"], study["hidden"])}</td>
                    </tr>`)
                document.querySelector(".table tbody").insertAdjacentHTML('beforeend', rows);
            });
        }

        getNewStudies();

        $(document).ready(function () {
            var windowHeight = $(window).height();
            $(document).on('scroll', function () {
                $('.loader').each(function () {
                    var self = $(this),
                        height = self.offset().top + self.height();
                    if ($(document).scrollTop() + windowHeight >= height) {
                        if (self.hasClass('hidden')) {
                            getNewStudies();
                        }
                    }
                });
            });
        });

        buildModal("danger", "Removing the activity", "Are you sure you want to remove the wizard?", document.querySelector("#trash-modal"), acceptDelete);
    </script>
@stop
