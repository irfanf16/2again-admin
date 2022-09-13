<?php
include_once 'common/head.php';
?>

<div id="wrapper" class="signup">
	<div class="container">
			<div class="logo">
				<a href="#">
					<img src="images/logo.png">
				</a>
			</div>
			<form class="form">
				<div class="form-group">
					<input type="email" class="form-control" placeholder="Enter your Email">
				</div>
				<div class="form-group">
					<input type="password" class="form-control" placeholder="Enter your Password">
				</div>
				<div class="form-group">
					<select class="form-control custom-select">
						<option selected>Select Country</option>
						<option>option 1</option>
						<option>option 1</option>
						<option>option 1</option>
						<option>option 1</option>
					</select>
				</div>
				<div class="form-group clearfix">
					<div class="pull-left">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck" name="example1">
							<label class="custom-control-label" for="customCheck">Remember Password ?</label>
						</div>
					</div>
					<div class="pull-right">
						<a href="#" class="forget-password">Forget Password ?</a>
					</div>
				</div>
				<div class="form-group text-center">
					<button type="submit" class="btn">signup</button>
				</div>
			</form>
		</div>
</div>
<?php
    include_once 'common/end-page.php';
?>