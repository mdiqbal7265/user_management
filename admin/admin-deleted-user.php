<?php 

	require_once 'assets/php/admin-header.php';

?>


<div class="row">
	<div class="col-lg-12">
		<div class="card my-2 border-danger">
			<div class="card-header bg-danger text-white">
				<h4 class="m-0">Total Deleted Users</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive" id="showAllDeletedUsers">
					<p class="text-center align-self-center lead">Please Wait..</p>
				</div>
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

		// Fetch All Deleted User Ajax Request
		fetchAllDeletedUsers();
		function fetchAllDeletedUsers(){
			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'post',
				data: {action: 'fetchAllDeletedUsers'},
				success:function(response){
					$("#showAllDeletedUsers").html(response);
					$("table").DataTable({
						order: [0, 'desc']
					});
				}
			});
		}

		// Restore an User Ajax Request
	    $("body").on('click', '.restoreBtn', function(event) {
	      event.preventDefault();
	      
	      restore_id = $(this).attr('id');
	      Swal.fire({
	        title: 'Are you sure want restore this user?',
	        text: "You won't be able to restore this!",
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes, restored it!'
	      }).then((result) => {
	        if (result.value) {
	          $.ajax({
	            url: 'assets/php/admin_action.php',
	            type: 'POST',
	            data: {restore_id: restore_id},
	            success:function(response){
	              Swal.fire(
	                'Restored!',
	                'User has been restored succesfully.',
	                'success'
	              )
	              fetchAllDeletedUsers();
	            }
	          });
	        }
	      });

	    });
	});
</script>

</body>
</html>