<?php
    include_once 'common/head.php';
?>
<div id="wrapper" class="inner-page">
    <?php
        include_once 'common/header-inner.php';
    ?>

    <div class="login">
        <div class="container">

            <form class="form">
                <div class="text-center mb-5">
                    <div class="logo">
                        <a href="#">
                            <img src="images/logo.svg" alt="logo name">
                        </a>
                    </div>
                    <h4>Sign in your account</h4>
                </div>
                <div class="form-group">
                    <label>Enter Email</label>
                    <input type="email" class="form-control" placeholder="example@gmail.com">
                </div>
                <div class="form-group">
                    <label>Enter Password</label>
                    <input type="password" class="form-control" placeholder="000000">
                </div>
                <div class="form-group forget-password">
                    <div class="form-check checkbox">
                        <input class="form-check-input" type="checkbox" value="" id="Remember">
                        <label class="form-check-label" for="Remember">
                            Remember
                        </label>
                    </div>
                    <a href="#" class="text-yellow">Forget Password ?</a>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn w-100">Login</button>
                </div>
                <div class="form-group text-center">
                    Are you new on 2 Again? <a href="#" class="text-yellow">Register</a>
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
