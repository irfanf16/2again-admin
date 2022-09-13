<div class="modal fade" id="login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                <i class="fal fa-times"></i>
            </button>
            <div class="modal-body text-center">
                <div class="logo">
                    <a href="#">
                        <img src="{{asset('web/images/logo.svg')}}" alt="logo name">
                    </a>
                </div>
                <h4>Find your best Partner</h4>
                <ul class="nav nav-tabs">
                    <li>
                        <button class="btn active" data-bs-toggle="tab" data-bs-target="#signin" type="button">Sign in</button>
                    </li>
                    <li>
                        <button class="btn" data-bs-toggle="tab" data-bs-target="#signup" type="button">Sign up</button>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane show active" id="signin">
                        <div class="login-btn-list">
                            <a href="{{route('login.email')}}" class="btn btn-yellow"><i class="icon-email"></i>Sign in with Email</a>
                            <a href="{{route('login.phone')}}" class="btn btn-white"><i class="icon-call"></i>Sign in with phone</a>
                            <a href="#" class="btn btn-dark"><i class="icon-apple"></i>Sign in with Apple</a>
                            <div class="divider"><span>Sign in with social</span></div>
                            <a href="#" class="btn btn-facebook"><i class="icon-facbook1"></i>Sign in with Facebook</a>
                            <a href="#" class="btn btn-google"><i class="icon-google"></i>Sign in with Google</a>
                        </div>
                        <hr class="mt-4">
                        <div class="text">
                            By Sign up you agree to 2again: <br>
                            <a href="#">Terms of Use</a> & <a href="#">Privacy Policy</a>
                        </div>
                    </div>
                    <div class="tab-pane" id="signup">
                        <div class="login-btn-list">
                            <a href="#" class="btn btn-yellow"><i class="icon-email"></i>Sign in with Email</a>
                            <a href="#" class="btn btn-white"><i class="icon-call"></i>Sign in with phone</a>
                        </div>
                        <hr class="mt-4">
                        <div class="text">
                            By Sign up you agree to 2again: <br>
                            <a href="#">Terms of Use</a> & <a href="#">Privacy Policy</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
