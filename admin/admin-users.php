<?php 

	require_once 'assets/php/admin-header.php';

?>


<div class="row">
	<div class="col-lg-12">
		<div class="card my-2 border-success">
			<div class="card-header bg-success text-white">
				<h4 class="m-0">Total Registered Users</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive" id="showAllUsers">
					<p class="text-center align-self-center lead">Please Wait..</p>
				</div>
			</div>
		</div>
	</div>

</div>

<!-- Display User Details In Modal -->
<div class="modal fade" id="showUserDetailsModal">
	<div class="modal-dialog modal-dialog-centered mw-100 w-50">
		<div class="modal-content">
			<div class="modal-header border-info bg-info text-white">
				<h4 class="modal-title" id="getName"></h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="card-deck">
					<div class="card border-primary">
						<div class="card-body">
							<p id="getMail"></p>
							<p id="getPhone"></p>
							<p id="getDob"></p>
							<p id="getGender"></p>
							<p id="getCreated"></p>
							<p id="getVerified"></p>
						</div>
					</div>
					<div class="card align-self-center" id="getImage">
						
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

		// Fetch All User Ajax Request
		fetchAllUsers();
		function fetchAllUsers(){
			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'post',
				data: {action: 'fetchAllUsers'},
				success:function(response){
					$("#showAllUsers").html(response);
					$("table").DataTable({
						order: [0, 'desc']
					});
				}
			});
		}

		// Display User in details
		$("body").on("click",".infoBtn",function(e){
			e.preventDefault();

			id = $(this).attr('id');
			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'POST',
				data: {id: id},
				success:function(response){
					data = JSON.parse(response);
					$("#getName").text('Name: '+data.name+' '+'(ID: '+data.id+')');
					$("#getMail").text('E-mail : '+data.email);
					$("#getPhone").text('Phone : '+data.phone);
					$("#getDob").text('Date Of Birth : '+data.dob);
					$("#getGender").text('Gender : '+data.gender);
					$("#getCreated").text('Joined On : '+data.created_at);
					$("#getVerified").text('Verified : '+data.verified);
					
					if(data.photo != ''){
						img = '<img src="../assets/img/'+data.photo+'" class="img-thumbnail img-fluid align-self-center" width="280px">';
						$("#getImage").html(img);
					}else{
						img = '<img src="../assets/img/avater.png" class="img-thumbnail img-fluid align-self-center" width="280px">';
						$("#getImage").html(img);
					}
				}
			});
		});

		// Delete a Note of an user Ajax Request
	    $("body").on('click', '.dltBtn', function(event) {
	      event.preventDefault();
	      
	      del_id = $(this).attr('id');
	      Swal.fire({
	        title: 'Are you sure?',
	        text: "You won't be able to delete this!",
	        type: 'warning',
	        showCancelButton: true,
	        confirmButtonColor: '#3085d6',
	        cancelButtonColor: '#d33',
	        confirmButtonText: 'Yes, delete it!'
	      }).then((result) => {
	        if (result.value) {
	          $.ajax({
	            url: 'assets/php/admin_action.php',
	            type: 'POST',
	            data: {del_id: del_id},
	            success:function(response){
	              Swal.fire(
	                'Deleted!',
	                'User has been deleted succesfully.',
	                'success'
	              )
	              fetchAllUsers();
	            }
	          });
	        }
	      });

	    });


	});
</script>

</body>
</html>