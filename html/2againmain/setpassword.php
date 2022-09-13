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
                    <h4>Enter Your Password</h4>
                </div>
                <div class="form-group">
                    <label>New Password</label>
                    <div class="password-field">
                        <input type="password" class="form-control" name="password" placeholder="000000">
                        <span class="showpassword"></span>
                    </div>
                    <small class="text-purple">Must be at least 8 characters.</small>
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <div class="password-field">
                        <input type="password" class="form-control" name="password" placeholder="000000">
                        <span class="showpassword"></span>
                    </div>
                    <small class="text-purple">Must be at least 8 characters.</small>
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

<script>
    var parent = document.querySelector("form");

    // password show/hide helper function
    function showHide(input, showText) {
        if (input.getAttribute("type") === "password") {
            input.setAttribute("type", "text");
            //showText.innerText = "hide";
        } else {
            input.setAttribute("type", "password");
            //showText.innerText = "show";
        }
    }

    // event delegation on event target match
    parent.addEventListener("click", event => {
        if (event.target.matches("span")) {
            var spanElm = event.target;
            var inputElm = spanElm.previousElementSibling;
            showHide(inputElm, spanElm);
        }
    });
</script>
