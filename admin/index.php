<?php 
	session_start();
	if (isset($_SESSION['username'])) {
		header('location:admin-dashboard.php');
		exit();
	}
 ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login || Admin</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
<body class="bg-dark admin-login">
	<div class="container h-100">
		<div class="row h-100 align-items-center justify-content-center">
			<div class="col-lg-5">
				<div class="card border-danger shadow-lg">
					<div class="card-header bg-danger">
						<h3 class="m-0 text-white"><i class="fas fa-user-cog"></i>&nbsp;Admin Login</h3>
					</div>
					<div class="card-body">
						<div id="log_alert"></div>
						<form action="" method="post" class="px-3" id="admin_login_form">
							<div class="form-group">
								<input type="text" name="username" class="form-control form-control-lg rounded-0" placeholder="username" required autofocus>
							</div>
							<div class="form-group">
								<input type="password" name="password" class="form-control form-control-lg rounded-0" placeholder="password" required>
							</div>
							<div class="form-group">
								<input type="submit" name="admin_login" class="btn btn-danger btn-block btn-lg rounded-0" value="Login" id="admin_login_btn">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>



<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		
		$("#admin_login_btn").click(function(e) {
			if($("#admin_login_form")[0].checkValidity()){
				e.preventDefault();

				$(this).val('Please Wait...');
				$.ajax({
					url: 'assets/php/admin_action.php',
					type: 'post',
					data: $("#admin_login_form").serialize()+'&action=admin_login',
					success:function(response) {
						if(response == 'admin_login'){
							window.location = 'admin-dashboard.php';
						}else{
							$("#log_alert").html(response);
							$("#admin_login_form")[0].reset();
						}
						$("#admin_login_btn").val('Log In');
					}
				});
			}
		});

	});
</script>
</body>
</html>