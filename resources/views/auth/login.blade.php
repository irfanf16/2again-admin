@extends('frontend.layouts.guest')
@section('content')
    <link rel="stylesheet" href="{{asset('frontend/build/css/intlTelInput.css')}}">
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
                            Login your account
                        </div>

                    </div>

                    <form action="{{route('login')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="ip" class="form-control border-bottom text-center" value="{{request()->ip()}}">
                        <input type="hidden" id="latitude" name="latitude" class="form-control border-bottom text-center" >
                        <input type="hidden" id="longitude" name="longitude" class="form-control border-bottom text-center">
                        <input type="hidden" id="fcm_token" name="fcm_token" class="form-control border-bottom text-center">

                        <div class="form-group">
                            @if(Request::Is('login_with_email'))
                                <label class="d-block">Enter Email</label>
                                <input type="email" class="form-control" name="email" value="{{old('email')}}"
                                       placeholder="example@gmail.com" required>
                                @if ($errors->has('email'))
                                    <span class="text-danger  p-3">{{ $errors->first('email') }}</span>
                                @endif
                        </div>
                        @else
                            <div class="form-group">
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
                            Are you new on 2 Again? <a href="{{route('loginregister')}}"
                                                       class="text-yellow">Register</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('frontend/build/js/intlTelInput.js')}}"></script>
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

        $('#phone').on('keypress', function (event) {
            var regex = new RegExp("^[0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        var phone_number = window.intlTelInput(document.querySelector("#phone"), {
            separateDialCode: true,
            preferredCountries: ["pk"],
            // hiddenInput: "full",
            utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
        });

        $("form").submit(function () {
            var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[name='phone']").val(full_number);


        });

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
        }
    </script>



@endsection
