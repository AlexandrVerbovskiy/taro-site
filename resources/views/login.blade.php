@include('layouts.header')
<div class="container py-4">
    <h2>Log In</h2>

    <form method="POST" action="{{url('/login')}}">
        {{ csrf_field() }}
        <div class="form-group mb-3">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>

        <div class="form-group mb-3">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="form-group mb-3">
            <button style="cursor:pointer" type="submit" class="btn btn-primary">Login</button>
        </div>

        <a href="{{url("forget-password")}}">Forget password</a>

        @if($errors->any())
            <h4>{{$errors->first()}}</h4>
        @endif
    </form>
</div>
@include('layouts.footer')
