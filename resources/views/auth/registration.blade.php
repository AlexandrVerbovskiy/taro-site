@include('layouts.header')
<div class="container py-4">
    <h2>Register</h2>
    <form method="POST" action="{{url('/registration')}}">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="first_name">First name:</label>
            <input type="text" class="form-control" value="{{ old('first_name') }}" id="first_name" name="first_name">
        </div>

        <div class="form-group mb-3">
            <label for="last_name">Last name:</label>
            <input type="text" class="form-control" value="{{ old('last_name') }}" id="last_name" name="last_name">
        </div>

        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" value="{{ old('email') }}" id="email" name="email">
        </div>

        <div class="form-group mb-3">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control" value="{{ old('phone') }}" id="phone" name="phone">
        </div>

        <div class="form-group mb-3">
            <label for="social_type">Social type:</label>
            <input type="text" class="form-control" value="{{ old('social_type') }}" id="social_type" name="social_type">
        </div>

        <div class="form-group mb-3">
            <label for="social_phone">Social phone:</label>
            <input type="text" class="form-control" value="{{ old('social_phone') }}" id="social_phone" name="social_phone">
        </div>

        <div class="form-group mb-3">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group mb-3">
            <label for="password_confirmation">Password Confirmation:</label>
            <input type="password" class="form-control" id="password_confirmation"
                   name="password_confirmation">
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
        </div>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>
</div>
@include('layouts.footer')
