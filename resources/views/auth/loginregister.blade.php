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
{{--                            <div class="font-12 mb-3">By Login you agree to 2 again: <a href="{{route('term/condition')}}">Terms of Use</a> &<br>--}}
{{--                                <a href="{{route('privacy')}}">Privacy Policy</a> </div>--}}
                        </div>
{{--                        <hr>--}}
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
                                    <form method="POST" action="{{route('social_media')}}">
                                        @csrf
                                        <input type="hidden" name="social_media" value="facebook" id="facebook">
                                        <input type="hidden" name="ip" class="form-control border-bottom text-center" value="{{request()->ip()}}">
                                        <input type="hidden" id="latitude" name="latitude" class="form-control border-bottom text-center" >
                                        <input type="hidden" id="longitude" name="longitude" class="form-control border-bottom text-center">
                                        <input type="hidden" id="fcm_token" name="fcm_token" class="form-control border-bottom text-center">
                                        <button type="submit" class="btn btn-facebook d-block mb-2 w-100"><i class="fab fa-facebook"></i> Sign in with Facebook</button>

                                    </form>
                                    <form method="POST" action="{{route('social_media')}}">
                                        @csrf
                                        <input type="hidden" name="social_media" value="google" id="google">
                                        <input type="hidden" name="ip" class="form-control border-bottom text-center" value="{{request()->ip()}}">
                                        <input type="hidden" id="latitude_google" name="latitude" class="form-control border-bottom text-center" >
                                        <input type="hidden" id="longitude_google" name="longitude" class="form-control border-bottom text-center">
                                        <input type="hidden" id="fcm_token_google" name="fcm_token" class="form-control border-bottom text-center">
                                        <button type="submit" class="btn btn-google d-block mb-2 mr-2 w-100"><i class="fab fa-google-plus"></i> Sign in with Google</button>

                                    </form>
{{--                                    <a href="{{route('auth/facebook')}}" class="btn btn-facebook d-block mb-2"><i class="fab fa-facebook"></i> Sign in with Facebook</a>--}}
{{--                                    <a href="{{route('auth/google')}}" class="btn btn-google d-block mb-2 mr-2"><i class="fab fa-google-plus"></i> Sign in with Google</a>--}}

                                    <hr>
                                    <div class="font-12 mb-3 text-center">By Login you agree to 2 again:<br> <a href="{{route('term/condition')}}" class="text-light-purple">Terms of Use</a> &
                                        <a href="{{route('privacy')}}" class="text-light-purple">Privacy Policy</a> </div>
                                </div>
                                <div id="Signup">
                                    <a href="{{route('register_email')}}" class="btn btn-yellow d-block mb-2"><i class="fal ico-email"></i>Sign up with Email</a>
                                    <a href="{{route('register_phone')}}" class="btn d-block mb-2"><i class="fal ico-phone"></i>Sign up with phone</a>
                                    <hr>
                                    <div class="font-12 mb-3 text-center">By Login you agree to 2 again:<br> <a href="{{route('term/condition')}}" class="text-light-purple">Terms of Use</a> &
                                        <a href="{{route('privacy')}}" class="text-light-purple">Privacy Policy</a> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        @if ($errors->has('latitude') || $errors->has('longitude') || $errors->has('fcm_token') )
        toastr.error('Kindly Enable location and Notifications');
        @endif


        $(document).ready(function(){
            getLocation();

            messaging.requestPermission().then(function () {
                return messaging.getToken();
            }).then(function (token) {
                console.log('token function')
                console.log(token);
                document.getElementById('fcm_token').value=token;
                document.getElementById('fcm_token_google').value=token;

            }).catch(function (err) {
                console.log(err);
            });
        });
        @if(Session::has('message'))

        toastr.success("{{ session('message') }}");
        @endif
        @if(Session::has('success'))

        toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif
        function getLocation() {
            console.log('get location');
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(showPosition);
            }else{
                toastr.error('Kindly Enable Your location');
            }
        }
        function showPosition(position) {
            document.getElementById('latitude').value=position.coords.latitude;
            document.getElementById('longitude').value=position.coords.longitude;
            document.getElementById('latitude_google').value=position.coords.latitude;
            document.getElementById('longitude_google').value=position.coords.longitude;
        }




    </script>
@endsection
