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
                    <h4>Choose an account</h4>
                </div>
                <div class="form-group pb-5">
                    <ul class="login-account-list">
                        <li>
                            <a href="#" class="btn btn-darkblue">
                                <i class="icon-call"></i>
                                <div class="description">
                                    <h5 class="mb-1">Bessie Hunt</h5>
                                    <div class="text-muted font-12">(086) 763-8744</div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn btn-darkblue">
                                <i class="icon-email"></i>
                                <div class="description">
                                    <h5 class="mb-1">Billie Cook</h5>
                                    <div class="text-muted font-12">gregory.baker@gmail.com</div>
                                </div>
                            </a>
                        </li>
                        <li class="pt-3">
                            <a href="#" class="btn">
                                <i class="icon-facbook1"></i>
                                <div class="description">
                                    <h5 class="mb-0">Facebook</h5>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn">
                                <i class="icon-google"></i>
                                <div class="description">
                                    <h5 class="mb-0">Google</h5>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="#" class="btn">
                                <i class="icon-apple"></i>
                                <div class="description">
                                    <h5 class="mb-0">Apple</h5>
                                </div>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="login-btn-list">
                    <button type="submit" class="btn btn-darkblue w-100">Login into another account</button>
                    <button type="submit" class="btn w-100">Create New 2again Account</button>
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


