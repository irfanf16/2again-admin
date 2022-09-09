@extends('frontend.layouts.guest')
@section('content')
    <link rel="stylesheet" href="{{asset('frontend/build/css/intlTelInput.css')}}">
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
                            @if(Request::Is('register_with_email'))
                            <div class="mb-3">
                                Enter your email address
                            </div>
                            @else
                                <div class="mb-3">
                                    Enter your Phone Number
                                </div>
                            @endif
                        </div>
                        <form action="{{route('register')}}" method="POST">
                            @csrf
                            <div class="form-group pt-5 pb-5">
                                @if(Request::Is('register_with_email'))

                                <input type="email" name="email" value="{{old('email')}}" class="form-control border-bottom text-center" placeholder="s.riley@yahoo.com">
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                                @else
                                    <input id="phone"  value="{{old('phone')}}" type="tel" class="form-control border-bottom " >
                                    <input name="phone"  value="" type="hidden">

                                @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                @endif

                                <br>
                                @if ($errors->has('ip'))
                                    <span class="text-danger">{{ $errors->first('ip') }}</span>
                                @endif<br>
{{--                                @if ($errors->has('latitude'))--}}
{{--                                    <span class="text-danger">{{ $errors->first('latitude') }}</span>--}}
{{--                                @endif<br>--}}
{{--                                @if ($errors->has('longitude'))--}}
{{--                                    <span class="text-danger">{{ $errors->first('longitude') }}</span>--}}
{{--                                @endif--}}
                            </div>
                            <input type="hidden" name="ip" class="form-control border-bottom text-center" value="192.168.10.23">
                            <input type="hidden" id="latitude" name="latitude" class="form-control border-bottom text-center" >
                            <input type="hidden" id="longitude" name="longitude" class="form-control border-bottom text-center">
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


    <script src="{{asset('frontend/build/js/intlTelInput.js')}}"></script>
    <script>
        $(document).ready(function(){
            getLocation();
        });

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
            preferredCountries:["pk"],
            // hiddenInput: "full",
            utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
        });

        $("form").submit(function() {
            var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
            $("input[name='phone']").val(full_number);
        });
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
        }
        @if ($errors->has('latitude'))
               toastr.error('Kindly Enable Your location');
        @endif
    </script>
@endsection
