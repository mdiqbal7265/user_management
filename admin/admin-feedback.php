<?php 

	require_once 'assets/php/admin-header.php';

?>


<div class="row">
	<div class="col-lg-12">
		<div class="card my-2 border-warning">
			<div class="card-header bg-warning text-white">
				<h4 class="m-0">Total Feedback From Users</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive" id="showAllFeedback">
					<p class="text-center align-self-center lead">Please Wait..</p>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Reply Feedback Modal -->
<div class="modal fade" id="showReplyModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Reply This Feedback</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form method="post" action="#" class="px-3" id="feedback_reply_form">
					<div class="form-group">
						<textarea name="message" id="message" class="form-control" rows="6" placeholder="Write your message here..." required></textarea>
					</div>
					<div class="form-group">
						<input type="submit" name="submit" value="Send Reply" class="btn btn-primary btn-block" id="feedback_reply_btn">
					</div>
				</form>
			</div>
		</div>
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
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script type="text/javascript">
	$(document).ready(function() {
		$("#open-nav").click(function() {
			$(".admin-nav").toggleClass('animate');
		});

		// Fetch All Feedback Ajax Request
		fetchAllFeedback();
		function fetchAllFeedback(){
			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'post',
				data: {action: 'fetchAllFeedback'},
				success:function(response){
					$("#showAllFeedback").html(response);
					$("table").DataTable({
						order: [0, 'desc']
					});
				}
			});
		}

		// Get Tge Current Row selected id & Feed back id
		var uid;
		var fid;
		$("body").on('click', '.replyBtn', function(event) {
			event.preventDefault();
			uid = $(this).attr('id');
			fid = $(this).attr('fid');
		});

		// Send Feedback Reply To user
		$("#feedback_reply_btn").click(function(event) {
			if($("#feedback_reply_form")[0].checkValidity()){
				event.preventDefault();
				let message = $("#message").val();
				$("#feedback_reply_btn").val('Please Wait...');

				$.ajax({
					url: 'assets/php/admin_action.php',
					type: 'post',
					data: {uid: uid, message: message, fid: fid},
					success:function(response){
						$("#feedback_reply_btn").val('Send Reply');
			            $("#feedback_reply_form")[0].reset();
			            $("#showReplyModal").modal('hide');
			            Swal.fire(
			            	'Send!',
			            	'Reply send succesfully to the user!',
			            	'success'
			            )
			            fetchAllFeedback();
					}
				});
			}
		});
	});
</script>

</body>
</html>