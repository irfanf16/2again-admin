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
                            <div class="mb-3">Enter Your Phone Number</div>
                            <div class="mb-3 font-12 text-gray">You will get a verification code on your phone number</div>
                        </div>
                        <form>
                            <div class="form-group pt-5 pb-5">
                                <div class="input-group-text">
                                    <div class="language-dropwdown dropdown ">
                                        <button class="dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="true">
                                            <img src="images/uk.svg">
                                            +145
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a href="#"><img src="images/uk.svg">+145</a></li>
                                            <li><a href="#"><img src="images/uk.svg">+145</a></li>
                                            <li><a href="#"><img src="images/uk.svg">+145</a></li>
                                        </ul>
                                    </div>
                                    <input type="text" class="form-control" placeholder="689-2046">

                                </div>
                            </div>
                            <div class="form-group text-center">
                                <a href="#" class="btn w-100" type="button">Continue</a>
                            </div>
                            <div class="form-group text-center mb-0">
                                Already have an account? <a href="login.php" class="text-yellow">Login</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
