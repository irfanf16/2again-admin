<!doctype html>
<html lang="en-US">
@include('web.landing.head')
<body>
<div id="mainwrapper" class="inner-page">
    @include('web.landing.header')
    @yield('content')
    @include('web.landing.footer')
</div>
@include('web.landing.end-page')

<script>
    @if ($errors->has('latitude') || $errors->has('longitude'))
    toastr.error('Kindly Enable location and Notifications');
    @endif
    @if( $errors->has('fcm_token'))
    toastr.error('Kindly Enable Notifications');
    @endif
    @if(Session::has('success'))
    toastr.success("{{ session('success') }}");
    @endif

    @if(Session::has('error'))
    toastr.error("{{ session('error') }}");
    @endif

    $(document).ready(function () {
        getLocation();
        messaging.requestPermission().then(function () {
            return messaging.getToken();
        }).then(function (token) {
            console.log('token function')
            console.log(token);
            document.getElementById('fcm_token').value = token;
        }).catch(function (err) {
            console.log(err);
        });
    });

    function getLocation() {
        console.log('get location');
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            toastr.error('Kindly Enable Your location');
        }
    }

    function showPosition(position) {
        document.getElementById('latitude').value = position.coords.latitude;
        document.getElementById('longitude').value = position.coords.longitude;
    }

    function getDeviceType() {
        const ua = navigator.userAgent;
        if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {
            return "tablet";
        }
        if (/Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(ua)) {
            return "mobile";
        }
        return "desktop";
    };
    document.getElementById('device_type').value = getDeviceType();
    document.getElementById('device_id').value = '{{strtok(exec('getmac'),' ')}}';
    document.getElementById('time_zone').value = Intl.DateTimeFormat().resolvedOptions().timeZone

    @if(request()->routeIs('login.phone'))
    $('#phone').on('keypress', function (event) {
        var regex = new RegExp("^[0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    var input = document.querySelector("#phone"),
        errorMsg = document.querySelector("#error-msg"),
        validMsg = document.querySelector("#valid-msg");

    // here, the index maps to the error code returned from getValidationError - see readme
    var errorMap = ["Invalid number", "Invalid country code", "Too short", "Too long", "Invalid number"];
    var phone_number = window.intlTelInput(input, {
        separateDialCode: true,
        preferredCountries: ["pk"],
        // hiddenInput: "full",
        utilsScript: "//cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.3/js/utils.js"
    });
    var reset = function () {
        input.classList.remove("error");
        errorMsg.innerHTML = "";
        errorMsg.classList.add("hide");
        validMsg.classList.add("hide");
    };

    // on blur: validate
    input.addEventListener('blur', function () {
        reset();
        if (input.value.trim()) {
            if (phone_number.isValidNumber()) {
                validMsg.classList.remove("hide");
            } else {
                input.classList.add("error");
                var errorCode = phone_number.getValidationError();
                errorMsg.innerHTML = errorMap[errorCode];
                errorMsg.classList.remove("hide");
            }
        }
    });

    // on keyup / change flag: reset
    input.addEventListener('change', reset);
    input.addEventListener('keyup', reset);

    $("form").submit(function () {
        var full_number = phone_number.getNumber(intlTelInputUtils.numberFormat.E164);
        $("input[name='phone']").val(full_number);
    });
    @endif

</script>

</body>
</html>
