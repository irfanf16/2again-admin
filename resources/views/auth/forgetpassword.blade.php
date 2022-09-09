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
                            @if(Request::Is('forget/email/password'))
                                <div class="mb-3">
                                    Enter your email address
                                </div>
                            @else
                                <div class="mb-3">
                                    Enter your Phone
                                </div>
                            @endif
                        </div>
                        <form action="{{route('forgot_password')}}" method="POST">
                            @csrf
                            <div class="form-group pt-5 pb-5">
                                @if(Request::Is('forget/email/password'))

                                    <input type="email" name="email" class="form-control border-bottom text-center"
                                           value="{{old('email')}}" placeholder="s.riley@yahoo.com">
                                    @if ($errors->has('email'))
                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                    @endif
                                @else
                                    <input id="phone"  value="{{old('phone')}}" type="tel"
                                           class="form-control border-bottom ">
                                    <input name="phone" value="" type="hidden">

                                @if ($errors->has('phone'))
                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="form-group text-center">
                                <button class="btn w-100" type="submit">Continue</button>
                            </div>
                            <div class="form-group text-center mb-0">
                                Already have an account? <a href="{{route('loginregister')}}"
                                                            class="text-yellow">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>

        @if(Session::has('success'))

        toastr.success("{{ session('success') }}");
        @endif

        @if(Session::has('error'))
        toastr.error("{{ session('error') }}");
        @endif
    </script>
    <script src="{{asset('frontend/build/js/intlTelInput.js')}}"></script>
    <script>
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
    </script>
@endsection
