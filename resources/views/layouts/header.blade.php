<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="/css/app.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
            integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"
            async></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
            integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"
            async></script>
    <style>
        #audio_media_view[src=""], #video_media_view[src=""], #image_media_view[src=""], #youtube_media_view[src=""],
        #audio_media_view[src=""]+br, #video_media_view[src=""]+br, #image_media_view[src=""]+br, #youtube_media_view[src=""]+br{
            display: none;
        }
    </style>
</head>
<body class="antialiased d-flex flex-column min-vh-100">

@include("layouts.vocabulary")

<script>

    const subscriptions = {};

    function subscribeOnChangeLanguage(selector, key) {
        subscriptions[selector] = key;
    }

    function subscribeOnChangeLanguageCustomWords(selector, key, obj) {
        vocabulary[key] = obj;
        subscriptions[selector] = key;
    }

    function changeLanguage(lang) {
        Object.keys(subscriptions).forEach(selector => {
            console.log( document.querySelector(selector));
            console.log(selector);
            document.querySelector(selector).innerHTML = vocabulary[subscriptions[selector]][lang];
        });
        localStorage.setItem("language", lang);

        for(let langButton of document.querySelectorAll('.lang_button')) {
            langButton.style.textDecoration = langButton.dataset.value === lang ? 'underline' : 'none';
        }
    }

    const get = (url, callback, ignoreSuccess=true) => {
        fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': <?=json_encode(csrf_token())?>
            }
        }).then(res => res.json()).then(res=> {
            if(typeof(res)=="object"){
                if(res.message){
                    if(!ignoreSuccess && res.error) showError(res.message);
                    if(!res.error) showSuccess(res.message);
                }
            }
            callback(res);
        }).catch(e => showError(e.message));
    }

    const post = (url, data, callback, ignoreSuccess=false) => {
        fetch(url, {
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': <?=json_encode(csrf_token())?>
            },
            method: 'POST',
            body: JSON.stringify(data)
        }).then(res => res.json()).then(res=> {
            if(typeof(res)=="object"){
                if(res.message){
                    if(!ignoreSuccess && res.error) showError(res.message);
                    if(!res.error) showSuccess(res.message);
                }
            }
            callback(res);
        }).catch(e => showError(e.message));
    }

    const btnFromEvent = e => {
        let elem = e.target;
        if (elem.tagName != "BUTTON") {
            elem = elem.closest('button');
        }
        return elem;
    }

    const getBtns = (editUrl, id, hidden = false) => `
            <a href="${editUrl + '/' + id}" type="button" class="btn btn-primary admin_button_SaniaZaebalEdition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="bi bi-pencil admin_button_img_SaniaZaebalEdition" viewBox="0 0 16 16">
                    <path
                        d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"></path>
                </svg>
            </a>

            <button type="button" class="btn admin_button_SaniaZaebalEdition change-visible ${hidden ? 'btn-danger' : 'btn-success'}" data-id="${id}" onclick="handleChangeVisibleClick(this)">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                     class="bi bi-eye admin_button_img_SaniaZaebalEdition" viewBox="0 0 16 16">
                    <path
                        d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"></path>
                    <path
                        d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"></path>
                </svg>
            </button>

            <button type="button" class="btn admin_button_SaniaZaebalEdition trash btn-danger" data-id="${id}" onclick="handleTrashClick(this)">
                <svg xmlns="http://www.w3.org/2000/svg" " fill="currentColor"
                     class="bi bi-trash admin_button_img_SaniaZaebalEdition" viewBox="0 0 16 16">
                    <path
                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path>
                    <path fill-rule="evenodd"
                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path>
                </svg>
            </button>`;

    function parseYoutubeUrl(link="") {
        if(!link) return "";
        if (link.includes("https://www.youtube.com") && link.includes("watch")) {
            console.log(link)
            link = link.split("watch?v=")[1];
            link = link.split("&")[0];

            link = "https://www.youtube.com/embed/" + link;
        } else if ("https://youtu.be") {
            link = link.split("https://youtu.be/")[1];
            link = "https://www.youtube.com/embed/" + link;
        }
        console.log(link);
        return link;
    }

    function makeid(length) {
        let result = '';
        const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;
        let counter = 0;
        while (counter < length) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
            counter += 1;
        }
        return result;
    }

    const buildModal = (type, title, body, trigger, onClick) => {
        const id = "id_" + makeid(5).toLowerCase();
        trigger.setAttribute('data-bs-toggle', 'modal');
        trigger.setAttribute('data-bs-target', `#${id}`);

        document.body.insertAdjacentHTML("beforeend", ` <!-- Modal -->
            <div class="modal fade" id="${id}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">${title}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    ${body}
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn close btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn accept btn-${type}">Save changes</button>
                  </div>
                </div>
              </div>
            </div>`);

        document.querySelector(`#${id} .accept`).addEventListener("click", () => {
            onClick();
            document.querySelector(`#${id} .close`).click();
        });
    }

    function closeMessageTimerStart(){
        setTimeout(()=> {
            document.querySelectorAll(".alert.show .btn-close").forEach(elem => {
                elem.click();
            })
        },5000)
    }

    function showError(message){
        document.querySelector(".message-parent").insertAdjacentHTML("afterbegin", `
             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
        closeMessageTimerStart();
    }

    function showSuccess(message){
        document.querySelector(".message-parent").insertAdjacentHTML("afterbegin", `
             <div class="alert alert-success alert-dismissible fade show" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>`);
        closeMessageTimerStart();
    }

    closeMessageTimerStart();
</script>


