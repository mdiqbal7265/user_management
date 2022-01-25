<?php
	session_start();
	if (isset($_SESSION['user'])) {
		header('location:home.php');
	}

	include 'assets/php/config.php';
	$db = new Database();

	$sql = "UPDATE visitors SET hits = hits+1 WHERE id = 0";
	$stmt = $db->conn->prepare($sql);
	$stmt->execute();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Management</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body>
	<div class="container">
		<!-- Login From Start -->
		<div class="row justify-content-center wrapper" id="login_box">
			<div class="col-lg-10 my-auto">
				<div class="card-group my_shadow">
					<div class="card rounded-left p-4" style="flex-grow: 1.4;">
						<h1 class="text-center font-weight-bold text-primary">Sign in to Account</h1>
						<hr class="my-3">
						<div id="log_alert"></div>
						<form action="#" method="post" class="p-3" id="login_form">
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0">
										<i class="far fa-envelope fa-lg"></i>
									</span>
								</div>
								<input type="email" name="email" id="email" class="form-control rounded-0" placeholder="E-Mail" value="<?php if(isset($_COOKIE['email'])){echo $_COOKIE['email']; } ?>" required>
							</div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0">
										<i class="fas fa-key fa-lg"></i>
									</span>
								</div>
								<input type="password" name="password" id="password" class="form-control rounded-0" placeholder="Password" value="<?php if(isset($_COOKIE['password'])){echo $_COOKIE['password']; } ?>" required>
							</div>
							<div class="form-group">
								<div class="custom-control custom-checkbox float-left">
									<input type="checkbox" name="rem" class="custom-control-input" id="custom_check" <?php if(isset($_COOKIE['email'])){echo 'checked';} ?>>
									<label for="custom_check" class="custom-control-label">Remember me</label>
								</div>
								<div class="forgot float-right">
									<a href="#" id="forgot_link">Forgot Password?</a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div class="form-group">
								<input type="submit" value="Sign In" id="login_btn" class="btn btn-primary btn-lg btn-block mybtn">
							</div>
						</form>
					</div>
					<div class="card justify-content-center rounded-right my_color p-4">
						<h1 class="text-center font-weight-bold text-white">Hello Friends!</h1>
						<hr class="my-3 bg-light my_hr">
						<p class="text-center font-weight-bolder text-light lead">
							Enter your personal details and start your journey with us!
						</p>
						<button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 my_link_btn" id="register_link">Sign Up</button>
					</div>
				</div>
			</div>
		</div>
		<!-- Login From End -->

		<!-- Register From Start -->
		<div style="display: none;" class="row justify-content-center wrapper" id="register_box">
			<div class="col-lg-10 my-auto">
				<div class="card-group my_shadow">
					<div class="card justify-content-center rounded-left my_color p-4">
						<h1 class="text-center font-weight-bold text-white">Welcome Back!</h1>
						<hr class="my-3 bg-light my_hr">
						<p class="text-center font-weight-bolder text-light lead">
							To keep connected with us please login with your personal info.
						</p>
						<button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 my_link_btn" id="login_link">Sign In</button>
					</div>
					<div class="card rounded-right p-4" style="flex-grow: 1.4;">
						<h1 class="text-center font-weight-bold text-primary">Create Account</h1>
						<hr class="my-3">
						<div id="reg_alert"></div>
						<form action="#" method="post" class="p-3" id="register_form">
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0">
										<i class="far fa-user fa-lg"></i>
									</span>
								</div>
								<input type="text" name="name" id="name" class="form-control rounded-0" placeholder="Fullname" required>
							</div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0">
										<i class="far fa-envelope fa-lg"></i>
									</span>
								</div>
								<input type="email" name="email" id="remail" class="form-control rounded-0" placeholder="E-Mail" required>
							</div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0">
										<i class="fas fa-key fa-lg"></i>
									</span>
								</div>
								<input type="password" name="password" id="rpassword" class="form-control rounded-0" placeholder="Password" required minlength="5">
							</div>
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0">
										<i class="fas fa-key fa-lg"></i>
									</span>
								</div>
								<input type="password" name="cpassword" id="crpassword" class="form-control rounded-0" placeholder="Confirm Password" required minlength="5">
							</div>
							<div class="form-group">
								<div id="passErr" class="text-danger font-weight-bold"></div>
							</div>
							<div class="form-group">
								<input type="submit" value="Sign Up" id="register_btn" class="btn btn-primary btn-lg btn-block mybtn">
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
		<!-- Register From End -->
		<!-- Forgot Password Form -->
		<div style="display: none;" class="row justify-content-center wrapper" id="forgot_box">
			<div class="col-lg-10 my-auto">
				<div class="card-group my_shadow">
					<div class="card justify-content-center rounded-left my_color p-4">
						<h1 class="text-center font-weight-bold text-white">Reset Password</h1>
						<hr class="my-3 bg-light my_hr">	
						<button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 my_link_btn" id="back_link">Back</button>
					</div>
					<div class="card rounded-right p-4" style="flex-grow: 1.4;">
						<h1 class="text-center font-weight-bold text-primary">Forgot Your Password</h1>
						<hr class="my-3">
						<div id="forgot_alert"></div>
						<p class="lead text-center text-secondary">To reset your password, enter the registered e-mail address and we will send you the reset instructions on your e-mail</p>
						<form action="#" method="post" class="p-3" id="forgot_form">
							<div class="input-group input-group-lg form-group">
								<div class="input-group-prepend">
									<span class="input-group-text rounded-0">
										<i class="far fa-envelope fa-lg"></i>
									</span>
								</div>
								<input type="email" name="email" id="femail" class="form-control rounded-0" placeholder="E-Mail" required>
							</div>					
							
							<div class="form-group">
								<input type="submit" value="Reset Password" id="forgot_btn" class="btn btn-primary btn-lg btn-block mybtn">
							</div>
						</form>
					</div>					
				</div>
			</div>
		</div>
		<!-- End Forgot password Form -->
	</div>


<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script>
	$(document).ready(function() {
		$("#register_link").click(function() {
			$("#login_box").hide();
			$("#register_box").show();
		});

		$("#login_link").click(function() {
			$("#login_box").show();
			$("#register_box").hide();
		});

		$("#forgot_link").click(function() {
			$("#login_box").hide();
			$("#forgot_box").show();
		});
		$("#back_link").click(function() {
			$("#login_box").show();
			$("#forgot_box").hide();
		});

		// Register Ajax Request

		$("#register_btn").click(function(e){
			if($("#register_form")[0].checkValidity()){
				e.preventDefault();
				$("#register_btn").val("Please Wait...");
				if($("#rpassword").val() != $("#crpassword").val()){
					$("#passErr").text('* Password did not matched!'); 
					$("#register_btn").val("Sign Up");
				}else{
					$("#passErr").text('');
					$.ajax({
						url: 'assets/php/action.php',
						type: 'POST',
						data: $("#register_form").serialize()+'&action=register',
						success:function(response){
							$("#register_btn").val("Sign Up");
							if(response == 'register')
							{
								window.location = 'home.php';
							}else{
								$("#reg_alert").html(response);
							}
						}
					});
					 
				}
			}
		});

		// Login ajax request

		$('#login_btn').click(function(e) {
			if($("#login_form")[0].checkValidity()){
				e.preventDefault();

				$("#login_btn").val('Please Wait...');
				$.ajax({
					url: 'assets/php/action.php',
					type: 'post',
					data: $("#login_form").serialize()+'&action=login',
					success:function(response){
						$("#login_btn").val('Sign In');
						if(response === 'login'){
							window.location = 'home.php';
						}else{
							$("#log_alert").html(response);
						}
					}
				});				
			}
		});

		// Forgot Password Ajax Request

		$('#forgot_btn').click(function(e) {
			if($("#forgot_form")[0].checkValidity()){
				e.preventDefault();

				$("#forgot_btn").val('Please Wait...');

				$.ajax({
					url: 'assets/php/action.php',
					type: 'post',
					data: $("#forgot_form").serialize()+'&action=forgot',
					success:function(response){
						$("#forgot_btn").val('Reset Password');
						$("#forgot_form")[0].reset();
						$("#forgot_alert").html(response)
					}
				});				
			}
		});


	});
</script>
</body>
</html>