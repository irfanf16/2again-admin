@extends('frontend.layouts.guest')
@section('content')

    <main id="main">
        <div class="login" style="background-image: url(images/bg3.jpg)">
            <div class="container">
                <div class="col">
                    <div class="content-box">
                        <div class="logo">
                            <a href="#">
                                <img src="{{asset('frontend/images/logo.svg')}}">
                            </a>
                        </div>
                        <div class="text-center">
                            <div class="mb-3">
                                Please Set Your Password
                            </div>
                        </div>
                        <hr>
                        <form id="submit_form" action="{{route('ResetPassword')}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label class="d-block">Password</label>
                                <input type="password" id="password" name="password" class="form-control"
                                       placeholder="000000" required>
                                {{--                                <small class="text-light-purple">Must be at least 8 characters.</small><br>--}}
                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label class="d-block">Confirm Password</label>
                                <input type="password" name="password_confirmation" id="confirm_password" class="form-control" placeholder="000000" required>
                                {{--                                <small class="text-light-purple">Both passwords must match.</small>--}}
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                                @endif
                            </div>
                            <div class="form-group mb-0">
                                <button class="btn w-100" id="submit">Reset Password</button>
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
        // $(document).ready(function () {
        //     $('#submit').click(function () {
        //         var password = document.getElementById('password').value;
        //         var confirm_password = document.getElementById('confirm_password').value;
        //         if(password  && confirm_password){
        //             if (password === confirm_password) {
        //                 $('#submit_form').submit();
        //             } else {
        //                 toastr.error("Both passwords must match");
        //             }
        //         }else{
        //             toastr.error("Please Enter Password First.!");
        //
        //         }
        //
        //     });
        //
        // });


    </script>
@endsection
