<?php require_once "assets/php/header.php"; ?>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-8 mt-3">
			<?php if($verified == 'Verified!'): ?>
			<div class="card border-primary">
				<div class="card-header lead text-center bg-primary text-white">
					Send Feedback to Admin!
				</div>
				<div class="card-body">
					<form action="#" method="post" class="px-4" id="feedback_form">
						<div class="form-group">
							<input type="text" name="subject" placeholder="Write your Subject.." class="form-control-lg form-control rounded-0" required>
						</div>
						<div class="form-group">
							<textarea name="feedback" class="form-control-lg form-control rounded-0" placeholder="Write Your Feedback Here..." rows="8" required></textarea>
						</div>

						<div class="form-group">
							<input type="submit" name="feedback" id="feedback_btn" value="Send Feedback" class="btn btn-primary btn-block btn-lg rounded-0">
						</div>
					</form>
				</div>
			</div>
			<?php else: ?>
				<h1 class="alert alert-info text-center text-secondary mt-5">Verify Your E-mail First to Send Feedback to Admin!</h1>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		// Send Feedback to Admin Ajax Request
		$("#feedback_btn").click(function(event) {
			if($("#feedback_form")[0].checkValidity()){
				event.preventDefault();

				$(this).val('Please Wait...');

				$.ajax({
					url: 'assets/php/process.php',
					type: 'post',
					data: $("#feedback_form").serialize()+'&action=feedback',
					success:function(response){
						$("#feedback_form")[0].reset();
						$("#feedback_btn").val('Send Feedback');
						Swal.fire({
							title : 'Feedback Succesfully sent to the Admin!!',
							type: 'success'
						});
					}
				});
			}
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