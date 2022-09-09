@extends('admin.layouts.app')
@section('content')

<div id="wrapper" class="fullwidth-page">

    <main id="main">
        <div class="login" style="background-image: url('{{asset('admin/images/bg1.jpg')}}')">
            <div class="container">
                <div class="col">
                    <div class="content-box">
                        <div class="logo">
                            <a href="#">
                                <img src="{{asset('admin/images/logo.svg')}}">
                            </a>
                        </div>
                        <div class="text-center">
                            <div class="font-18 mb-3">
                               System User Login
                            </div>
                        </div>
                        <hr>
                        <form  action="{{route('admin.login')}}" method="POST">
                            @csrf
{{--                            @if(\Session::has('error'))--}}
{{--                                <div class="alert alert-danger" style="text-align:center;">--}}
{{--                                    {!! \Session::get('error') !!}--}}
{{--                                </div>--}}
{{--                            @endif--}}
                            <div class="form-group">
                                <label class="d-block">Enter Email</label>
                                <input type="email" name="email" class="form-control" placeholder="example@gmail.com" autocomplete="off">
                                @if ($errors->has('email'))
                                    <span class="text-danger  p-3">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <input type="hidden" id="zone" name="zone" value="">
                            <div class="form-group">
                                <label class="d-block">Enter password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password">
                                @if ($errors->has('password'))
                                    <span class="text-danger  p-3">{{ $errors->first('password') }}</span>
                                @endif
                            </div>
{{--                            <div class="form-group">--}}
{{--                                <div class="d-flex justify-content-between">--}}
{{--                                    <div class="checkbox">--}}
{{--                                        <input type="checkbox" class="form-check-input" id="exampleCheck1">--}}
{{--                                        <label class="form-check-label" for="exampleCheck1">Remember</label>--}}
{{--                                    </div>--}}
{{--                                    <a href="#" class="text-yellow">Forgot password? </a>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="form-group text-center">
                                <button class="btn w-100" type="submit">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

{{--    @include('admin.inc.footer')--}}
</div>
<script>
    document.getElementById('zone').value=Intl.DateTimeFormat().resolvedOptions().timeZone
</script>

@endsection
