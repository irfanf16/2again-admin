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
                            <div class="mb-3">Enter OTP 4 Digit Code</div>
                            <div class="mb-3 font-12 text-gray">You will get a verification code on your Email</div>
                        </div>
                        <form action="{{route('verifyUser')}}" method="POST">
                            @csrf
                            <div class="form-group pt-5 pb-5">
                                <div class="otp-container">
                                    <input type="tel" name="first_digit" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                                    <input type="tel" name="second_digit" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                                    <input type="tel" name="third_digit" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                                    <input type="tel" name="fourth_digit" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                                </div>

                                @if ($errors->has('otp'))
                                    <span class="text-danger  p-3">{{ $errors->first('otp') }}</span>
                                @endif
                            </div>

                            <div class="form-group text-center">
                                <div class="mb-2 text-yellow">01:20s</div>
                                <button  class="btn w-100" type="submit">Continue</button>
                            </div>
                            <div class="form-group text-center mb-0">
                                Didn’t get a code? <a href="{{route('otp/resend')}}" class="text-yellow">Resend</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        @if(Session::has('message'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.success("{{ session('message') }}");
        @endif
            @if(Session::has('success'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.success("{{ session('success') }}");
        @endif

            @if(Session::has('error'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.error("{{ session('error') }}");
        @endif

            @if(Session::has('info'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.info("{{ session('info') }}");
        @endif

            @if(Session::has('warning'))
            toastr.options =
            {
                "closeButton" : true,
                "progressBar" : true
            }
        toastr.warning("{{ session('warning') }}");
        @endif
    </script>

@endsection
