@extends('frontend.layouts.guest')
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
                            <div class="mb-3">Enter OTP 4 Digit Code</div>
                            <div class="mb-3 font-12 text-gray">You will get a verification code</div>
                        </div>
                        <form action="{{route('verifyUser')}}" method="POST" class="digit-group"
                              data-group-name="digits" data-autosubmit="false" autocomplete="off">
                            @csrf
                            <div class="form-group pt-5 pb-5">
                                <div class="otp-container">
                                    <input type="tel" name="first_digit" class="form-control otp-number-input "
                                           maxlength="1" autocomplete="off" id="digit-1" data-next="digit-2">
                                    <input type="tel" name="second_digit" class="form-control otp-number-input "
                                           maxlength="1" autocomplete="off" id="digit-2" data-next="digit-3"
                                           data-previous="digit-1">
                                    <input type="tel" name="third_digit" class="form-control otp-number-input "
                                           maxlength="1" autocomplete="off" id="digit-3" data-next="digit-4"
                                           data-previous="digit-2">
                                    <input type="tel" name="fourth_digit" class="form-control otp-number-input "
                                           maxlength="1" autocomplete="off" id="digit-4" data-previous="digit-3">
                                </div>

                                @if ($errors->has('otp'))
                                    <span class="text-danger  p-3">{{ $errors->first('otp') }}</span>
                                @endif
                            </div>

                            <div class="form-group text-center">
                                <div class="mb-2 text-yellow" id="timer"></div>
                                <button class="btn w-100" type="submit">Continue</button>
                            </div>

                        </form>
                        <div id="resend"></div>

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

        $(document).ready(function () {

            var seconds = 1000 * 60; //1000 = 1 second in JS
            var timer;
             myFunction();
            function myFunction() {

                if (seconds == 60000)
                    timer = setInterval(myFunction, 1000)
                seconds -= 1000;
                document.getElementById("timer").innerHTML = '0:' + seconds / 1000+'s';
                if (seconds <= 0) {
                    clearInterval(timer);
                    $('#resend').append(
                        $('<div/>',{'class':'form-group text-center mb-0'}).append(
                            ' Didn’t get a code?',
                            $('<a/>',{href:'{{route('otp/resend')}}','class':'text-yellow'}).append(
                                ' Resend',
                            )
                            )
                    )

                }
                document.getElementById("timer").innerHTML = "0:" + seconds / 1000+'s';

            }


        })


        $('.digit-group').find('input').each(function () {
            $(this).attr('maxlength', 1);
            $(this).on('keyup', function (e) {
                var parent = $($(this).parent());

                if (e.keyCode === 8 || e.keyCode === 37) {
                    var prev = parent.find('input#' + $(this).data('previous'));

                    if (prev.length) {
                        $(prev).select();
                    }
                } else if ((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 65 && e.keyCode <= 90) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode === 39) {
                    var next = parent.find('input#' + $(this).data('next'));

                    if (next.length) {
                        $(next).select();
                    } else {
                        if (parent.data('autosubmit')) {
                            parent.submit();
                        }
                    }
                }
            });
        });

    </script>

@endsection
