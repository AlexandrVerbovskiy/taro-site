@include('layouts.header')
<div class="container py-4 message-parent">
    @include("layouts.error-message")
    <h2>Register</h2>
    <form method="POST" action="{{url('/edit-profile')}}">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="first_name">First name:</label>
            <input type="text" class="form-control"
                   value="{{ old('first_name') ? old('first_name') : $first_name  }}"
                   id="first_name" name="first_name">
        </div>

        <div class="form-group mb-3">
            <label for="last_name">Last name:</label>
            <input type="text" class="form-control"
                   value="{{old('last_name') ? old('last_name') : $last_name }}"
                   id="last_name"
                   name="last_name">
        </div>

        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control"
                   value="{{old('email') ? old('email') : $email}}"
                   id="email" name="email">
        </div>

        <input type="hidden" class="form-control"
               value="{{$id}}"
               id="id" name="id">

        <div class="form-group mb-3">
            <label for="phone">Phone:</label>
            <input type="text" class="form-control"
                   value="{{old('phone') ? old('phone') : $phone }}"
                   id="phone" name="phone">
        </div>

        <div class="form-group mb-3">
            <label for="social_type">Social type:</label>
            <input type="text" class="form-control"
                   value="{{old('social_type') ? old('social_type') : $social_phone }}"
                   id="social_type"
                   name="social_type">
        </div>

        <div class="form-group mb-3">
            <label for="social_phone">Social phone:</label>
            <input type="text" class="form-control"
                   value="{{old('social_phone') ? old('social_phone') : $social_phone }}"
                   id="social_phone"
                   name="social_phone">
        </div>

        <div class="form-group">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>
@include('layouts.footer')
