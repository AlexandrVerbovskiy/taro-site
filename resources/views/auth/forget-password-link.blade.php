@include('layouts.main-header')
<div class="container">
    <br><br><br><br><br><br>
<main class="login-form">
    <div class="cotainer">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card" style="background-color: #a9c6ff; border-radius: 25px; border: 0; margin: 0 20px">
                    <div class="modal-header d-flex justify-content-center"
                         style="border: 0; margin: 18px 0; padding-bottom: 0">
                        <p class="modal-title reset_password_title" id="exampleModalLongTitle " style="/*font-size: 30px;*/">Скинути пароль</p>
                    </div>
                    <div class="card-body" style="padding: 0">

                            <form action="{{ url('reset-password') }}" method="POST">

                                @csrf
                                <div class="modal-body padding_for_form">
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="" >

                                        <input type="text" id="email_address" placeholder="Пошта" class="form-control input_form reset_password_email" name="email" required autofocus>
                                        @if ($errors->has('email'))
                                            <span class="text-danger">{{ $errors->first('email') }}</span>
                                        @endif

                                    </div>

                                <div class="">
                                        <input type="password" id="password" class="form-control input_form reset_password_password" placeholder="Пароль" name="password" required autofocus>
                                        @if ($errors->has('password'))
                                            <span class="text-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>

                                <div class="">
                                        <input type="password" id="password-confirm" class="form-control input_form reset_password_confirmation" placeholder="Повторіть пароль" name="password_confirmation" required autofocus>
                                        @if ($errors->has('password_confirmation'))
                                            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                        @endif

                                    </div>

                                <div class="">
                                    <button type="submit" class="btn btn-primary form_main_button reset_password_submit">
                                        Reset Password
                                    </button>
                                </div>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script>
    subscribeOnChangeLanguage(".reset_password_title", "reset_password_title");
    subscribeOnChangePlaceholderLanguage(".reset_password_email", "reset_password_email");
    subscribeOnChangePlaceholderLanguage(".reset_password_password", "reset_password_password");
    subscribeOnChangePlaceholderLanguage(".reset_password_confirmation", "reset_password_confirmation");
    subscribeOnChangeLanguage(".reset_password_submit", "reset_password_submit");
</script>
@include('layouts.footer')

