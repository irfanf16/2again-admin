<header id="headermain">
    <div class="container">
        <div class="logomain">
            <a href="/">
                <img src="{{asset('frontend/images/logo.svg')}}" alt="logo name">
            </a>
        </div>
        @if(!request()->routeIs('login.email')  && !request()->routeIs('login.phone'))
        <a href="#" class="btn login-btn pull-right" data-bs-toggle="modal" data-bs-target="#notify_popup">Login</a>
       @endif
    </div>
</header>
