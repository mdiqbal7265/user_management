<?php require_once "assets/php/header.php"; ?>

<div class="container">
	<div class="row justify-content-center my-2">
		<div class="col-lg-6 mt-4" id="show_all_notification">
			
		</div>
	</div>
</div>

<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
		
		// Fetch Notifications of an user
		fetchNotification();
		function fetchNotification(){
			$.ajax({
				url: 'assets/php/process.php',
				type: 'POST',
				data: {action: 'fetchNotification'},
				success:function(response){
					$("#show_all_notification").html(response);
				}
			});			
		}

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

		// Remove Notification
		$("body").on("click",".close", function(e){
			e.preventDefault();

			notification_id = $(this).attr('id');

			$.ajax({
				url: 'assets/php/process.php',
				type: 'post',
				data: {notification_id: notification_id},
				success:function(response){
					checkNotification();
					fetchNotification();
				}
			});
		});

	});
</script>
</body>
</html>