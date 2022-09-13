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
                    <h4>Enter Your Phone Number</h4>
                </div>
                <div class="form-group pt-5 pb-5">
                    <input type="tel" id="phone" class="form-control" placeholder="Phone Number" name="phoneNumber">
                </div>

                <div class="form-group">
                    <button type="submit" class="btn w-100">Continue</button>
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


