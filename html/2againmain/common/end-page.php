<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta2/dist/js/bootstrap-select.min.js"></script>
<script type="text/javascript" src="js/jquery.smartWizard.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script type="text/javascript" src="js/main.js"></script>
<script type="text/javascript" src="js/slick.js"></script>
<script type="text/javascript" src="js/intlTelInput.min.js"></script>
<script>
    $(document).ready(function() {
        $('#contactForm')
            .find('[name="phoneNumber"]')
            .intlTelInput({

                allowExtensions: true,
                formatOnDisplay: true,
                autoFormat: true,
                autoHideDialCode: true,
                autoPlaceholder: true,
               // defaultCountry: "auto",
                //ipinfoToken: "yolo",

                nationalMode: false,
                numberType: "MOBILE",
                //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
                preferredCountries: ['sa', 'ae', 'qa','om','bh','kw','ma'],
                preventInvalidNumbers: true,
                separateDialCode: true,

                utilsScript: 'https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/11.0.9/js/utils.js',

            });
    });
</script>
</body>

</html>


<?php
$project_path = '';
include_once $project_path.'popups/login.php';
?>
