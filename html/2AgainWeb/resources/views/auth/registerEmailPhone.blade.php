@extends('web.layouts.guest')
@section('content')

    <main id="main">
        <div class="login" style="background-image: url(images/bg2.jpg)">
            <div class="container">
                <div class="col">
                    <div class="content-box">
                        <div class="logo">
                            <a href="#">
                                <img src="{{asset('frontend/images/logo.svg')}}">
                            </a>
                        </div>
                        <div class="text-center">
                            @if(Request::Is('register/email'))
                                <div class="mb-3">
                                    Enter your email address
                                </div>
                            @else
                                <div class="mb-3">
                                    Enter your Phone Number
                                </div>
                            @endif
                        </div>
                        <form action="{{route('signUp')}}" method="POST">
                            @csrf
                            <div class="form-group pt-5 pb-5">
                                @if(Request::Is('register/email'))

                                    <input type="email" name="email" value="{{old('email')}}"
                                           class="form-control border-bottom text-center"
                                           placeholder="s.riley@yahoo.com">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                @else
                                    <input id="phone" value="{{old('phone')}}" type="tel"
                                           class="form-control border-bottom ">
                                    <input name="phone" value="" type="hidden">
                                    <span id="valid-msg" class="hide">✓ Valid</span>
                                    <span id="error-msg" class="hide"></span>
                                    @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                @endif
                                <br>
                                @if ($errors->has('ip'))
                                    <span class="text-danger">{{ $errors->first('ip') }}</span>
                                @endif<br>
                            </div>
                            <input type="hidden" name="ip" class="form-control border-bottom text-center"
                                   value="{{request()->ip()}}">
                            <input type="hidden" id="latitude" name="latitude"
                                   class="form-control border-bottom text-center">
                            <input type="hidden" id="longitude" name="longitude"
                                   class="form-control border-bottom text-center">
                            <div class="form-group text-center">
                                <button class="btn w-100" type="submit">Continue</button>
                            </div>
                            <div class="form-group text-center mb-0">
                                Already have an account?
                                @if(Request::Is('register/email'))
                                <a href="{{route('login.email')}}" class="text-yellow">Login</a>
                                @else
                                    <a href="{{route('login.phone')}}" class="text-yellow">Login</a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection
