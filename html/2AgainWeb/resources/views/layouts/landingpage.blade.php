<!doctype html>
<html lang="en-US">
@include('landing.head')
<body class="scroll-color">
<div id="mainwrapper" class="inner-page">
    @include('landing.header')
    @yield('content')
    @include('landing.footer')
</div>
@include('landing.end-page')
<script>
    $(document).ready(function () {
        $('#keep-in-touch').on('click', function (event) {
            event.preventDefault();
            if (firstname.value == '') {
                fn.innerHTML = 'Please enter first name';
                return
            } else {
                fn.innerHTML = ''
            }
            if (lastname.value == '') {
                ln.innerHTML = 'Please enter last name';
                return
            } else {
                ln.innerHTML = ''
            }
            if (email.value =='') {
                em.innerHTML = 'Please Enter email';
                return;
            } else {
                em.innerHTML = ' '

            }
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {
                em.innerHTML = '';
            } else {
                em.innerHTML = 'You have entered an invalid email address!'
                return;
            }
            if (message.value == '') {
                msg.innerHTML = 'Please enter message';
                return
            } else {
                msg.innerHTML = ''
            }
            try {
                $.ajax({
                    method: "POST",
                    url: window.location.origin + '/keep/in/touch',
                    data: {
                        firstname: $('#firstname').val(),
                        lastname: $('#lastname').val(),
                        email: $('#email').val(),
                        message: $('#message').val(),
                        _token: $('meta[name="csrf_token"]').attr('content')
                    }
                }).done(function (response) {

                    if(response.data==true){
                        toastr.success(response.response);
                        $("#keep-in-touch-form")[0].reset();
                    }
                    if(response.data==false){
                        toastr.error(response.response.email[0]);
                    }
                })
            } catch (e) {
                results.innerHTML = e;
            }
        });
        $('#join-popup-request').on('click', function (event) {
            event.preventDefault();
            if (pre_registration_email.value =='') {
                pre_em.innerHTML = 'Please Enter email';
                return;
            } else {
                pre_em.innerHTML = ' '

            }
            if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(pre_registration_email.value)) {
                pre_em.innerHTML = '';
            } else {
                pre_em.innerHTML = 'You have entered an invalid email address!'
                return;
            }
            try {
                $.ajax({
                    method: "POST",
                    url: window.location.origin + '/subscriber',
                    data: {
                        email: $('#pre_registration_email').val(),
                        _token: $('meta[name="csrf_token"]').attr('content')
                    }
                }).done(function (response) {

                    if(response.data==true){
                        toastr.success(response.response);
                        $("#join-popup-request-form")[0].reset();
                        $('#join_popup').modal('hide')
                    }
                    if(response.data==false){
                        toastr.error(response.response.email[0]);
                    }
                })
            } catch (e) {
                results.innerHTML = e;
            }
        });

    })

</script>
</body>
</html>
