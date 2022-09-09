@extends('frontend.layouts.guest')
@section('content')

    <main id="main">
        <div class="login" style="background-image: url(images/bg2.jpg)">
            <div class="container">
                <div class="col">
                    <div class="content-box">
                        <div class="logo">
                            <a href="#">
                                <img src="images/logo.svg">
                            </a>
                        </div>
                        <div class="text-center">
                            <div class="mb-3">
                                Enter your email address
                            </div>


                        </div>
                        <form action="{{route('register_email')}}" method="POST">
                            @csrf
                            <div class="form-group pt-5 pb-5">
                                <input type="email" name="email" class="form-control border-bottom text-center" placeholder="s.riley@yahoo.com">
                                <input type="hidden" name="ip" class="form-control border-bottom text-center" value="192.168.10.23">
                                <input type="hidden" name="latitude" class="form-control border-bottom text-center" value="31.5204">
                                <input type="hidden" name="longitude" class="form-control border-bottom text-center" value="74.3587" >


                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                                <br>
                                @if ($errors->has('ip'))
                                    <span class="text-danger">{{ $errors->first('ip') }}</span>
                                @endif<br>
                                @if ($errors->has('latitude'))
                                    <span class="text-danger">{{ $errors->first('latitude') }}</span>
                                @endif<br>
                                @if ($errors->has('longitude'))
                                    <span class="text-danger">{{ $errors->first('longitude') }}</span>
                                @endif
                            </div>
                            <div class="form-group text-center">
                                <button  class="btn w-100" type="submit">Continue</button>
                            </div>
                            <div class="form-group text-center mb-0">
                                Already have an account? <a href="{{route('loginregister')}}" class="text-yellow">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
