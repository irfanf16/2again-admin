<!doctype html>
<html lang="en-US">
@include('web.inc.head')
<body>
<div id="wrapper">
    @include('web.inc.header')
    <main id="main">
        <div class="container">
            @include('web.inc.main-sidebar')
            @yield('content')
        </div>
    </main>
@include('web.inc.footer')
@include('web.inc.end-page')
</body>
</html>
