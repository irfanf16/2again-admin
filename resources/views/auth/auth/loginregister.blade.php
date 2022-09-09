@extends('frontend.layouts.guest')
@section('content')
    <main id="main">
        <div class="login" style="background-image: url(images/bg1.jpg)">
            <div class="container">
                <div class="col">
                    <div class="content-box">
                        <div class="logo">
                            <a href="#">
                                <img src="{{asset('frontend/images/logo.svg')}}">
                            </a>
                        </div>
                        <div class="text-center">
                            <div class="font-18 mb-3">
                                Get Started
                            </div>
{{--                            @include('frontend.inc.flash-message')--}}
                            <div class="font-12 mb-3">By Login you agree to 2 again: <a href="#">Terms of Use</a> &<br>
                                <a href="#">Privacy Policy</a> </div>
                        </div>
                        <hr>
                        <div class="p-2">
                            <ul class="tabset">
                                <li class="active"><a href="#Login">Login</a></li>
                                <li><a href="#Signup">Sign up</a></li>
                            </ul>
                            <div class="tab-content  py-3">
                                <div id="Login">
                                    <a href="{{route('login_with_email')}}" class="btn btn-yellow d-block mb-2"><i class="fal ico-email"></i> Sign in with Email</a>
                                    <a href="{{route('login_with_phone')}}" class="btn btn-white d-block mb-2"><i class="fal ico-phone"></i> Sign in with phone</a>
{{--                                    <a href="#" class="btn btn-dark d-block mb-2"><i class="fab fa-apple"></i> Sign in with Apple</a>--}}
                                    <hr>
                                    <div class="font-12 mb-3 text-center">
                                        Sign in with social
                                    </div>
                                    <a href="{{route('auth/facebook')}}" class="btn btn-facebook d-block mb-2"><i class="fab fa-facebook"></i> Sign in with Facebook</a>
                                    <a href="{{route('auth/google')}}" class="btn btn-google d-block mb-2 mr-2"><i class="fab fa-google-plus"></i> Sign in with Google</a>
                                    <hr>
                                    <div class="font-12 mb-3 text-center">By Login you agree to 2 again:<br> <a href="#" class="text-light-purple">Terms of Use</a> &
                                        <a href="#" class="text-light-purple">Privacy Policy</a> </div>
                                </div>
                                <div id="Signup">
                                    <a href="{{route('register_email')}}" class="btn btn-yellow d-block mb-2"><i class="fal ico-email"></i>Sign up with Email</a>
                                    <a href="{{route('register_phone')}}" class="btn d-block mb-2"><i class="fal ico-phone"></i>Sign up with phone</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        @if(Session::has('message'))

        toastr.success("{{ session('message') }}");
        @endif
            @if(Session::has('success'))

        toastr.success("{{ session('success') }}");
        @endif

            @if(Session::has('error'))

        toastr.error("{{ session('error') }}");
        @endif

            @if(Session::has('info'))

        toastr.info("{{ session('info') }}");
        @endif

            @if(Session::has('warning'))

        toastr.warning("{{ session('warning') }}");
        @endif
    </script>
@endsection
