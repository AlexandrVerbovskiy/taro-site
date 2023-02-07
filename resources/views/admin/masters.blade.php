@extends('layouts.admin')
@section('content')
    <div class="container">
        <div style="display: flex; justify-content: flex-end; margin: 20px 0 10px;">
            <a href="{{url("/admin/create-master")}}" class="btn btn-primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                     class="bi bi-pencil" viewBox="0 0 16 16">
                    <path
                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                </svg>
                Add
            </a>
        </div>
        <table class="table table-responsive table-responsive-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">First name</th>
                <th scope="col">Last name</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>

            @foreach ($masters as $master)
                <tr data-id="{{$master->id}}">
                    <th scope="row">{{$master->id}}</th>
                    <td>{{$master->first_name}}</td>
                    <td>{{$master->last_name}}</td>
                    <td>
                        <a href="{{url("/admin/edit-master/".$master->id)}}" type="button" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-pencil" viewBox="0 0 16 16">
                                <path
                                    d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                            </svg>
                        </a>

                        <button type="button" class="btn change-visible btn-success" data-id="{{$master->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-eye" viewBox="0 0 16 16">
                                <path
                                    d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                                <path
                                    d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                            </svg>
                        </button>

                        <button type="button" class="btn trash btn-danger" data-id="{{$master->id}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                 class="bi bi-trash" viewBox="0 0 16 16">
                                <path
                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                                <path fill-rule="evenodd"
                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <button id="trash-modal" style="display: none;">Trash</button>
    <script>
        const post = (url, data, callback) => {
            fetch(url, {
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': <?=json_encode(csrf_token())?>
                },
                method: 'POST',
                body: JSON.stringify(data)
            }).then(res => res.json()).then(callback).catch(e => {
                alert("error");
                console.log(e.message)
            });
        }

        const btnFromEvent = e => {
            let elem = e.target;
            if (elem.tagName != "BUTTON") {
                elem = elem.closest('button');
            }
            return elem;
        }

        let trashId = null;

        const acceptDelete = () => {
            console.log(trashId);
            post('{{url('/admin/master-delete')}}', {id: trashId}, res => {
                console.log(`tr[data-id='${trashId}']`)
                document.querySelector(`tr[data-id='${trashId}']`).remove();
                console.log(res)
            });
        }

        const handleChangeVisibleClick = (e) => {
            const btn = btnFromEvent(e);
            const id = btn.dataset.id;
            post('{{url('/admin/master-change-visible')}}', {id}, res => {
                if (!res.error) {
                    btn.classList.toggle("btn-danger");
                    btn.classList.toggle("btn-success");
                }
                console.log(res);
            });
        }

        const handleTrashClick = (e) => {
            trashId = btnFromEvent(e).dataset.id;
            document.querySelector("#trash-modal").click();
        }

        document.querySelectorAll(".trash").forEach(trash => trash.addEventListener("click", handleTrashClick));
        document.querySelectorAll(".change-visible").forEach(btn => btn.addEventListener("click", handleChangeVisibleClick));

        buildModal("danger", "Removing the master", "Are you sure you want to remove the wizard?", document.querySelector("#trash-modal"), acceptDelete);
    </script>
@stop
