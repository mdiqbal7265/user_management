<?php require_once "assets/php/header.php"; ?>


<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			<div class="card rounded-0 mt-3 border-primary">
				<div class="card-header border-primary">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">Profile</a>
						</li>
						<li class="nav-item">
							<a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab">Edit Profile</a>
						</li>
						<li class="nav-item">
							<a href="#changePass" class="nav-link font-weight-bold" data-toggle="tab">Change Password</a>
						</li>
					</ul>
				</div>
				<div class="card-body">
					<div class="tab-content">
						<!-- Profile tab start -->
						<div class="tab-pane container active" id="profile">
							<div class="card-deck">
								<div class="card border-primary">
									<div class="card-header bg-primary text-light text-center lead">
										User ID: <?= $id; ?>
									</div>
									<div class="card-body">
										<div id="verify_email_alert"></div>
										<p class="card-text p-2 m-1 rounded" style="border: 1px solid #0275d8;"><b>Name: </b><?= $name; ?></p>
										<p class="card-text p-2 m-1 rounded" style="border: 1px solid #0275d8;"><b>E-mail: </b><?= $email; ?></p>
										<p class="card-text p-2 m-1 rounded" style="border: 1px solid #0275d8;"><b>Gender: </b><?= $gender; ?></p>
										<p class="card-text p-2 m-1 rounded" style="border: 1px solid #0275d8;"><b>Date Of Birth: </b><?= $dob; ?></p>
										<p class="card-text p-2 m-1 rounded" style="border: 1px solid #0275d8;"><b>Phone: </b><?= $phone; ?></p>
										<p class="card-text p-2 m-1 rounded" style="border: 1px solid #0275d8;"><b>Registered On: </b><?= $created; ?></p>
										<p class="card-text p-2 m-1 rounded" style="border: 1px solid #0275d8;"><b>E-mail Verified: </b><?= $verified; ?>
										<?php if($verified == 'Not Verified!'): ?>
											<a href="#" id="verify_email" class="float-right">Verify Now</a>
										<?php endif; ?>
										</p>
										<div class="clearfix"></div>
									</div>
								</div>
								<div class="card border-primary align-self-center">
									<?php if(!$photo): ?>
										<img src="assets/img/avater.png" class="img-thumbnail img-fluid" width="408px">
									<?php else: ?>
										<img src="<?= 'assets/img/'.$photo ?>" class="img-thumbnail img-fluid" width="408px">
									<?php endif; ?>
								</div>
							</div>
						</div>
						<!-- Profile tab end; -->
						<!-- Edit Profile tab content -->
						<div class="tab-pane container fade" id="editProfile">
							<div class="card-deck">
								<div class="card border-danger align-self-center">
								<?php if(!$photo): ?>
									<img src="assets/img/avater.png" class="img-thumbnail img-fluid" width="408px">
								<?php else: ?>
									<img src="<?= 'assets/img/'.$photo ?>" class="img-thumbnail img-fluid" width="408px">
								<?php endif; ?>
								</div>
								<div class="card border-danger">
									<form action="" method="post" class="px-3 mt-2" enctype="multipart/form-data" id="profile_update_from">
										<input type="hidden" name="oldimage" value="<?= $photo; ?>">
										<div class="form-group m-0">
											<label for="profilePhoto" class="m-1">Upload Profile Image</label>
											<input type="file" name="image" id="profilePhoto">
										</div>
										<div class="form-group m-0">
											<label for="name" class="m-1">Name: </label>
											<input type="text" name="name" id="name" class="form-control" value="<?= $name; ?>">
										</div>
										<div class="form-group m-0">
											<label for="gender" class="m-1">Gender: </label>
											<select name="gender" id="gender" class="form-control">
												<option value="" <?php if($gender == null){echo 'selected';} ?>>Select Gender</option>
												<option value="Male" <?php if($gender == 'Male'){echo 'selected';} ?>>Male</option>
												<option value="Female" <?php if($gender == 'Female'){echo 'selected';} ?>>Female</option>
											</select>
										</div>
										<div class="form-group m-0">
											<label for="dob" class="m-1">Date Of Birth: </label>
											<input type="date" name="dob" id="dob" class="form-control" value="<?= $dob; ?>">
										</div>
										<div class="form-group m-0">
											<label for="phone" class="m-1">Phone: </label>
											<input type="tel" name="phone" id="phone" class="form-control" value="<?= $phone; ?>">
										</div>
										<div class="form-group mt-2">
											<input type="submit" name="profile_update" value="Update Profile" class="btn btn-danger btn-block" id="profile_update_btn">
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- Edit Profile tab content end -->
						<!-- Password Change Tab -->
						<div class="tab-pane container fade" id="changePass">
							<div class="card-deck">
								<div class="card border-success">
									<div class="card-header bg-success text-white text-center lead">
										Change Password
									</div>
									<div class="card-body">
										<div id="alert"></div>
										<form action="#" method="post" class="px-3 mt-2" id="password_change_form">
											<div class="form-group">
												<label for="curpass">Enter Your Current Password</label>
												<input type="password" name="curpass" placeholder="Current Password.." class="form-control" id="curpass" required minlength="5">
											</div>
											<div class="form-group">
												<label for="newpass">Enter Your New Password</label>
												<input type="password" name="newpass" placeholder="New Password.." class="form-control" id="newpass" required minlength="5">
											</div>
											<div class="form-group">
												<label for="cnewpass">Enter Your Confirm New Password</label>
												<input type="password" name="cnewpass" placeholder="Confirm New Password.." class="form-control" id="cnewpass" required minlength="5">
											</div>
											<div class="form-group">
												<p id="password_error" class="text-danger"></p>
											</div>
											<div class="form-group">
												<input type="submit" name="changepass" value="Change Password" class="btn btn-success btn-block btn-lg" id="change_pass_btn">
											</div>
										</form>
									</div>
								</div>
								<div class="card border-success align-self-center">
									<img src="assets/img/password.png" class="img-thumbnail img-fluid" width="408px">
								</div>
							</div>
						</div>
						<!-- Password Change Tab End -->
					</div>
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
		
		// Profile Update Details
		$('#profile_update_from').submit(function(event) {
			event.preventDefault();

			$.ajax({
				url: 'assets/php/process.php',
				type: 'POST',
				processData: false,
				contentType: false,
				cache: false,
				data: new FormData(this),
				success:function(response){
					location.reload();
				}
			});			
		});

		// Change Password Ajax Request

		$("#change_pass_btn").click(function(event) {
			if($("#password_change_form")[0].checkValidity()){
				event.preventDefault();
				$("#change_pass_btn").val("Please Wait...");

				if($("#newpass").val() != $("#cnewpass").val()){
					$("#password_error").text('* Password did not matched!');
					$("#change_pass_btn").val("Change Password");
				}else{
					$.ajax({
						url: 'assets/php/process.php',
						type: 'POST',
						data: $("#password_change_form").serialize()+'&action=change_pass',
						success:function(response) {
							$("#alert").html(response);
							$("#change_pass_btn").val("Change Password");
							$("#password_error").text('');
							$("#password_change_form")[0].reset();
						}
					});					
				}
			}

		});

		// Verify Email Ajax Request
		$("#verify_email").click(function(event) {
			event.preventDefault();
			$(this).text('Please Wait...');

			$.ajax({
				url: 'assets/php/process.php',
				type: 'post',
				data: {action: 'verify_email'},
				success:function(response){
					$("#verify_email_alert").html(response);
					$("##verify_email").text('Verify Now');
				}
			});			
		});

		// Check Notification
		checkNotification();
		function checkNotification(){
			$.ajax({
				url: 'assets/php/process.php',
				type: 'post',
				data: {action: 'checkNotification'},
				success:function(response){
					$("#checkNotification").html(response);
				}
			});
		}



	});
</script>
</body>
</html>