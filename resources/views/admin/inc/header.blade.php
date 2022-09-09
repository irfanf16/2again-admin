<header id="header">
    <div class="container-fluid">
        <div class="logo">
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('admin/images/group.svg') }}">
            </a>
        </div>
        <h4 class="d-inline-block my-2"> @yield('page_title')</h4>

        <div class="right-header-box gap-3">
{{--          <form class="search-form">--}}
{{--              <div class="form-group">--}}
{{--                  <input type="search" class="form-control" placeholder="Search">--}}
{{--                  <button type="submit" class="btn"><i class="fal ico-search"></i> </button>--}}
{{--              </div>--}}
{{--          </form>--}}
{{--          <a href="#" class="btn btn-light medium circle"><i class="fal ico-bell"></i><span class="active-status bg-red"></span></a>--}}
          <div class="dropdown">
              <button  class="user-profile p-0 btn transparent dropdown-toggle" data-bs-toggle="dropdown">
                  <div class="user-img">
                      <img src="{{ $profile_pic }}">
                  </div>
                  <div class="user-title">
                      @if(auth()->user())
                      {{ auth()->user()->name }}
                      @endif
                  </div>
                  <i class="far fa-chevron-down"></i>
              </button>
              <ul class="dropdown-menu">
                  <li><a  href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                  <li><a  href="{{route('admin.profile')}}">Profile</a></li>
                  <li><a  href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();">Logout</a></li>
              </ul>
          </div>

          <form id="logout" method="POST" action="{{ route('admin.logout') }}">
              @csrf
          </form>

        </div>
    </div>
</header>
