<?php
    include_once 'common/head.php';
?>
<div id="wrapper" class="inner-page">
    <?php
        include_once 'common/header-inner.php';
    ?>

    <div class="login d-block">
        <div class="container">
            <div id="smartwizard">
                <ul class="nav">
                    <li>
                        <a class="nav-link" href="#step-1">1</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#step-2">2</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#step-3"> 3</a>
                    </li>
                    <li>
                        <a class="nav-link" href="#step-4">4</a>
                    </li>
                </ul>
                <form class="form" style="max-width: 100%">
                    <div class="tab-content">
                        <div id="step-1" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <h4 class="text-center mb-5">Enter personal details</h4>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label>First Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label>Last Name</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Date Of Birth</label>
                                            <input type="text" class="form-control datepicker" placeholder="MM/DD/YYYY">
                                            <small class="text-danger">Must be 18 and over to use 2again</small>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <div class="d-flex align-items-center">
                                                <label>Select your gender</label>
                                                <div class="gendar-row">
                                                    <div class="form-check radio gendar1">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="Male">
                                                        <label class="form-check-label" for="Male">
                                                            <i class="icon-gender-male text-blue"></i>
                                                            Male
                                                        </label>
                                                    </div>
                                                    <div class="form-check radio gendar1">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="Female">
                                                        <label class="form-check-label" for="Female">
                                                            <i class="icon-gender-female text-red"></i>
                                                            Female
                                                        </label>
                                                    </div>
                                                    <div class="form-check radio gendar1">
                                                        <input class="form-check-input" type="radio" name="flexRadioDefault" id="Other">
                                                        <label class="form-check-label" for="Other">
                                                            <i class="icon-other text-yellow-dark"></i>
                                                            Other
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label>Date Of Birth</label>
                                            <select>
                                                <option>Pakistan</option>
                                                <option>Pakistan</option>
                                                <option>Pakistan</option>
                                                <option>Pakistan</option>
                                            </select>
                                        </div>
                                        <div class="col-md-12 custom-flex-space">
                                            <div class="form-group">
                                                <div class="form-check checkbox">
                                                    <input class="form-check-input" type="checkbox" value="" id="terms">
                                                    <label class="form-check-label" for="terms">
                                                        By signup you agree to 2again: <a href="#" class="text-purple">Terms of Use & Privacy Policy</a>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <button type="button" class="btn  sw-btn-next">Continue</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-2" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <h4 class="text-center">I am interested in</h4>
                                    <p class="text-center text-yellow mb-5">Please select anyone</p>
                                    <div class="form-group">
                                        <div class="gendar-row p-0">
                                            <div class="form-check radio gendar2">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="Man">
                                                <label class="form-check-label" for="Man">
                                                    <i class="icon-man bg-blue"></i>
                                                    Man
                                                </label>
                                            </div>
                                            <div class="form-check radio gendar2">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="Woman">
                                                <label class="form-check-label" for="Woman">
                                                    <i class="icon-women bg-red"></i>
                                                    Woman
                                                </label>
                                            </div>
                                            <div class="form-check radio gendar2">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="Everyone">
                                                <label class="form-check-label" for="Everyone">
                                                    <i class="icon-everyone bg-yellow-dark"></i>
                                                    Everyone
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group text-center pt-5">
                                        <button type="button" class="btn btn-secondary  sw-btn-next" style="min-width: 200px">Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-3" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <h4 class="text-center">Verify your account</h4>
                                    <p class="text-center text-yellow mb-5">Take your two photos using camera, which will be used for verification only</p>
                                    <div class="form-group  mb-5">
                                        <div class="img-box m-auto" style="max-width: 220px;">
                                            <img src="images/verification-img.svg">
                                        </div>
                                    </div>
                                    <div class="form-group text-center pt-5">
                                        <button type="button" class="btn btn-secondary  sw-btn-next" style="min-width: 200px">Continue</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="step-4" class="tab-pane" role="tabpanel">
                            <div class="row">
                                <div class="col-md-8 offset-md-2">
                                    <h4 class="text-center">Position your face in the camera</h4>
                                    <p class="text-center text-yellow mb-5">Take two photos</p>
                                    <div class="camera-section">
                                        <div id="my_camera"></div>
                                       <!-- <div id="results">
                                            <i class="icon-single-image"></i>
                                            <i class="icon-single-image"></i>
                                        </div>-->
                                        <ul id="results">
                                            <li><i class="icon-single-image"></i></li>
                                        </ul>
                                        <div class="row pt-4">
                                            <div class="col-md-3">
                                                <button class="btn btn-secondary w-100 text-muted" type="button" onClick="cancel_preview()">
                                                    <i class="icon-camera-retake"></i>
                                                    Retake
                                                </button>
                                            </div>
                                            <div class="col-md-6">
                                                <button type="button" onClick="take_snapshot()" class="btn w-100">Start Capture</button>
                                            </div>
                                            <div class="col-md-3">
                                                <button class="btn btn-secondary w-100 text-muted" type="button" onClick="save_photo()">
                                                    <i class="fas fa-check-circle"></i>
                                                    Save
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php
        include_once 'common/footer-inner.php';
    ?>
</div>
<?php
    include_once 'common/end-page.php';
?>
<script type="text/javascript" src="js/webcam.min.js"></script>
<script language="JavaScript">
    Webcam.set({
        width: 552,
        height: 366,
        image_format: 'jpeg',
        jpeg_quality: 100
    });
    Webcam.attach( '#my_camera' );

    function preview_snapshot() {
        // play sound effect
        try { shutter.currentTime = 0; } catch(e) {;} // fails in IE
        shutter.play();

        // freeze camera so user can preview current frame
        Webcam.freeze();

        // swap button sets
        document.getElementById('pre_take_buttons').style.display = 'none';
        document.getElementById('post_take_buttons').style.display = '';
    }

   /* function cancel_preview() {
        // cancel preview freeze and return to live camera view
        Webcam.unfreeze();

        // swap buttons back to first set
        document.getElementById('pre_take_buttons').style.display = '';
        document.getElementById('post_take_buttons').style.display = 'none';
    }*/

    function save_photo() {
        // actually snap photo (from preview freeze) and display it
        Webcam.snap( function(data_uri) {
            // display results in page
            document.getElementById('results').innerHTML =
                //'<h2>Here is your large, cropped image:</h2>' +
                '<div class="img-box" style="background-image: url('+data_uri+')"></div>';
                //'<a href="'+data_uri+'" target="_blank">Open image in new window...</a>';

            // shut down camera, stop capturing
            Webcam.reset();

            // show results, hide photo booth
            document.getElementById('results').style.display = '';
            document.getElementById('my_photo_booth').style.display = 'none';
        } );
    }



    function take_snapshot() {
        // take snapshot and get image data
        Webcam.snap( function(data_uri) {
            // display results in page
            $('#results').append (
                $('<li/>').append(
                    $('<div/>',{'class':'img-box',style:'background-image: url('+data_uri+')'})
                )
            )
        } );
    }
</script>
