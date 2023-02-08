@extends('layouts.admin')
@section('content')
    <div class="container">
        <div style="display: flex; justify-content: flex-end; margin: 20px 0 10px;">
            <a href="{{url("/admin/create-info-post")}}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-pencil" viewBox="0 0 16 16">
                    <path
                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                </svg>
                Add
            </a>
            <input type="text" name="search" placeholder="Search..."/>
            <button id="search" type="button" class="btn btn-danger">Search</button>
        </div>
        <table class="table table-responsive table-responsive-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="loader hidden"></div>
    </div>
    <button id="trash-modal" style="display: none;">Trash</button>

    <script>
        let showed = 0;
        const count = 1;
        const canShow = "{{$count}}";
        let trashId = null;
        let search = "";

        document.querySelector("#search").addEventListener("click", () => {
            search = document.querySelector("input[name=search]").value;
            showed = 0;
            document.querySelector("table tbody").innerHTML="";
            getNewPost();
        })

        const acceptDelete = () => {
            console.log(trashId);
            post('{{url('/admin/info-post-delete')}}', {id: trashId}, res => {
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
            post('{{url('/admin/info-post-change-visible')}}', {id}, res => {
                if (!res.error) {
                    e.classList.toggle("btn-danger");
                    e.classList.toggle("btn-success");
                }
                console.log(res);
            });
        }

        const getNewPost = () => {
            console.log(showed, count)
            document.querySelector(".loader").classList.remove('hidden');
            if (showed >= canShow) return document.querySelector(".loader").classList.add('hidden');
            get("{{url('/get-infos-posts')}}" + "?start=" + showed + "&count=" + count+"&search="+search, data => {
                document.querySelector(".loader").classList.add('hidden');
                if (data.error) return;
                let rows = "";
                showed += data.posts.length;
                data.posts.forEach(post =>
                    rows += `
                       <tr data-id=${post["id"]}>
                        <th scope="row">${post["id"]}</th>
                        <td>${post["title"]}</td>
                        <td>${getBtns('{{url("/admin/edit-info-post")}}', post["id"])}</td>
                    </tr>`)
                document.querySelector(".table tbody").insertAdjacentHTML('beforeend', rows);
            });
        }

        getNewPost();

        $(document).ready(function () {
            var windowHeight = $(window).height();
            $(document).on('scroll', function () {
                $('.loader').each(function () {
                    var self = $(this),
                        height = self.offset().top + self.height();
                    if ($(document).scrollTop() + windowHeight >= height) {
                        if (self.hasClass('hidden')) {
                            getNewPost();
                        }
                    }
                });
            });
        });

        buildModal("danger", "Removing the activity", "Are you sure you want to remove the wizard?", document.querySelector("#trash-modal"), acceptDelete);
    </script>
@stop
