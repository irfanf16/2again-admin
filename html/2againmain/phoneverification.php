<?php
    include_once 'common/head.php';
?>
<div id="wrapper" class="inner-page">
    <?php
        include_once 'common/header-inner.php';
    ?>

    <div class="login">
        <div class="container">

            <form class="form" id="contactForm">
                <div class="text-center mb-5">
                    <div class="logo">
                        <a href="#">
                            <img src="images/logo.svg" alt="logo name">
                        </a>
                    </div>
                    <h4>Enter Verification Code</h4>
                </div>
                <div class="form-group pt-5 pb-5">
                    <div class="otp-container">
                        <input type="tel" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                        <input type="tel" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                        <input type="tel" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                        <input type="tel" class="form-control otp-number-input" maxlength="1" autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn w-100">Continue</button>
                </div>
                <div class="form-group text-center mb-0">
                    Didn’t get a code? <br>
                    <a href="login.php" class="text-muted text-decoration-underline d-inline px-2">Resend</a><span class="text-yellow"> 01:20s</span>
                </div>
            </form>
        </div>
    </div>

    <?php
        include_once 'common/footer-inner.php';
    ?>

</div>
<?php
    include_once 'common/end-page.php';
?>


