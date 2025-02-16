@extends('layouts.admin')
@section('content')
    <div class="container">
        <h3 class="text-center title_margin" style="margin: 24px 0">Користовачі</h3>
        <div style="display: flex; justify-content: flex-end; margin: 20px 0 10px;">
            <!--<a href="{{url("/admin/create-info")}}" class="btn btn-primary admin_button_add">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="bi bi-pencil admin_add_img" viewBox="0 0 16 16">
                    <path
                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                </svg>
                Add
            </a>-->
            <input type="text" class="admin_search" name="search" placeholder="Search..."/>
            <a id="search" href="#"><img src="{{ URL("image/loupe.png")}}" class="admin_button_search align-middle"></a>
            <!--<button id="search" type="button" class="btn btn-danger admin_button_search">Search</button>-->
        </div>
        <div class="table table-responsive table-responsive-sm">
            <table class="table ">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Email</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
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
        let showed = 0;
        const count = 20;
        const canShow = "{{$count}}";
        let search = "";

        document.querySelector("#search").addEventListener("click", () => {
            search = document.querySelector("input[name=search]").value;
            showed = 0;
            canShow = true;
            document.querySelector("table tbody").innerHTML="";
            getNewUser();
        })

        const changeAdmin = (id, elem) => {
            get("{{url('/admin/change-admin-users')}}" + "?id=" + id, data => {
                console.log(data);
                if (data.error) return;

                elem.classList.toggle("btn-danger");
                elem.classList.toggle("btn-success");

                if (elem.classList.contains("btn-success")) {
                    elem.innerHTML = "Admin";
                } else {
                    elem.innerHTML = "User";
                }
            })
        }

        const getNewUser = () => {
            document.querySelector(".loader").classList.remove('hidden');
            if (showed >= canShow) return document.querySelector(".loader").classList.add('hidden');
            get("{{url('/admin/get-users')}}" + "?start=" + showed + "&count=" + count+"&search="+search, data => {
                document.querySelector(".loader").classList.add('hidden');
                if (data.error) return;
                let rows = "";
                showed += data.users.length;
                data.users.forEach(user =>
                    rows += `
                       <tr>
                        <th scope="row">${user["id"]}</th>
                        <td>${user["email"]}</td>
                        <td>${user["first_name"]}</td>
                        <td>${user["last_name"]}</td>
                        <td><button style="margin: 0" class="btn ${user["admin"] ? 'btn-success' : 'btn-danger'} admin_table_button" onclick="changeAdmin(${user["id"]}, this)">${user["admin"] ? 'Admin' : 'User'}</button></td>
                    </tr>`)
                document.querySelector(".table tbody").insertAdjacentHTML('beforeend', rows);

            });
        }

        getNewUser();

        $(document).ready(function () {
            var windowHeight = $(window).height();
            $(document).on('scroll', function () {
                $('.loader').each(function () {
                    var self = $(this),
                        height = self.offset().top + self.height();
                    if ($(document).scrollTop() + windowHeight >= height) {
                        if (self.hasClass('hidden')) {
                            getNewUser();
                        }
                    }
                });
            });
        });

    </script>
@stop
