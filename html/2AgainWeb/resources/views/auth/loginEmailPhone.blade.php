@extends('web.layouts.guest')
@section('content')
    <div class="loginmain">
        <div class="container">

            <form action="{{route('signIn')}}" method="POST" enctype="multipart/form-data" id="contactForm" class="form">
                @csrf
                <div class="text-center mb-5">
                    <div class="logomain">
                        <a href="#">
                            <img src="{{asset('frontend/images/logo.svg')}}" alt="logo name">
                        </a>
                    </div>
                    <h4>Sign in your account</h4>
                </div>
                <input type="hidden" name="ip" value="{{request()->ip()}}">
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">
                <input type="hidden" id="fcm_token" name="fcm_token">
                <input type="hidden" id="device_id" name="device_id">
                <input type="hidden" id="device_type" name="device_type">
                <input type="hidden" id="time_zone" name="time_zone">
                @if(request()->routeIs('login.email'))
                    <div class="form-group">
                        <label class="d-block">Enter Email</label>
                        <input type="email" class="form-control" name="email" value="{{old('email')}}"
                               placeholder="example@gmail.com" required>
                        @if($errors->has('email'))
                            <span class="text-danger  p-3">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                @else
                    <div class="form-group ">
                        <label class="d-block">Enter phone</label>
                        <input id="phone" value="{{old('phone')}}" type="tel" class="form-control" required>
                        <input name="phone" value="" type="hidden">

                        @if ($errors->has('phone'))
                            <span class="text-danger  p-3">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                @endif
                <div class="form-group">
                    <label class="d-block">Enter password</label>
                    <input type="password" name="password" class="form-control" placeholder="Enter password"
                           required>
                    @if ($errors->has('password'))
                        <span class="text-danger  p-3">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <div class="checkbox">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1">
                            <label class="form-check-label" for="exampleCheck1">Remember</label>
                        </div>
                        @if(Request::Is('login_with_email'))
                            <a href="{{route('forget_email_password')}}" class="text-yellow">Forgot
                                password? </a>
                        @else
                            <a href="{{route('forget_phone_password')}}" class="text-yellow">Forgot
                                password? </a>
                        @endif
                    </div>
                </div>
                <div class="form-group text-center">
                    <button href="#" class="btn w-100" type="submit">Login</button>
                </div>
                <div class="form-group text-center mb-0">
                    Are you new on 2 Again? <a href="{{route('loginregister')}}" class="text-yellow">Register</a>
                </div>
            </form>
        </div>
    </div>

@endsection
