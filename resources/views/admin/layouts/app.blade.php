<!doctype html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('admin/images/favicon.svg') }}">
    <title>2again</title>
    <link media="all" rel="stylesheet" type="text/css" href="{{ asset('admin/css/main.css') }}"/>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link media="all" rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/0.8.2/css/flag-icon.min.css"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>

{{--        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>--}}




    {{--toster--}}
    <link rel="stylesheet" type="text/css"
          href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    @if(request()->routeIs('terms') || request()->routeIs('privacy') || request()->routeIs('GDPR'))

    <link rel="stylesheet" href="{{asset('ckeditor/samples/css/samples.css')}}">
    @endif
    <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    <script src="{{asset('ckeditor/samples/js/sample.js')}}"></script>
</head>
<body>
<div id="wrapper">
    @if(auth()->user())
        @include('admin.inc.header')
    @endif
    <div id="main">
        @if(auth()->user())
        @include('admin.inc.sidebar')
        @endif
        @yield('content')
    </div>
        @if(auth()->user())
    @include('admin.inc.footer')
        @endif

</div>


<script type="text/javascript" src="{{ asset('admin/js/bootstrap.min.js') }}"></script>
<script type="text/javascript"
        src="https://andreruffert.github.io/rangeslider.js/assets/rangeslider.js/dist/rangeslider.min.js"></script>
<script type="text/javascript" src="{{ asset('admin/js/main.js') }}"></script>
<script type="text/javascript" src="{{ asset('admin/js/slick.js') }}"></script>
<script type="text/javascript">
    $(window).on('load', function () {
        $('#Verifyaccountwithpicture').modal('show');
    });
</script>

<script>
    @if(Session::has('success'))

    toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))

    toastr.error("{{ session('error') }}");
    @endif

    @if(Session::has('info'))

    toastr.info("{{ session('info') }}");
    @endif

    @if(Session::has('warning'))

    toastr.warning("{{ session('warning') }}");
    @endif
</script>
<script type="text/javascript" src="{{ asset('admin/js/custom.js') }}"></script>
</body>
</html>
