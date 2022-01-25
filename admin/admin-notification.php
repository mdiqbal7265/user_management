<?php 

	require_once 'assets/php/admin-header.php';

?>


<div class="row justify-content-center my-2">
	<div class="col-lg-6 mt-4" id="showNotification">
		
	</div>
</div>




<!-- Footer Area -->
			</div>
		</div>
	</div>
<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#open-nav").click(function() {
			$(".admin-nav").toggleClass('animate');
		});

		// Fetch Notification
		fetchNotofication()
		function fetchNotofication(){
			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'post',
				data: {action: 'fetchNotofication'},
				success:function(response){
					$("#showNotification").html(response);				
				}
			});
		}

		// Check Notification
		checkNotification();
		function checkNotification(){
			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'post',
				data: {action: 'checkNotification'},
				success:function(response){
					$("#checkNotification").html(response);
				}
			});			
		}

		// Remove Notification
		$("body").on('click', '.close', function(event) {
			event.preventDefault();
			notification_id = $(this).attr('id');

			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'post',
				data: {notification_id: notification_id},
				success:function(response){
					fetchNotofication();
					checkNotification();
				}
			});
		});

	});
</script>

</body>
</html>