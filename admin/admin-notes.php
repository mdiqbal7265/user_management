<?php 

	require_once 'assets/php/admin-header.php';

?>


<div class="row">
	<div class="col-lg-12">
		<div class="card my-2 border-primary">
			<div class="card-header bg-primary text-white">
				<h4 class="m-0">Total Notes By All Users</h4>
			</div>
			<div class="card-body">
				<div class="table-responsive" id="showAllNotes">
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

		// Fetch All Notes Ajax Request
		fetchAllNotes();
		function fetchAllNotes(){
			$.ajax({
				url: 'assets/php/admin_action.php',
				type: 'post',
				data: {action: 'fetchAllNotes'},
				success:function(response){
					$("#showAllNotes").html(response);
					$("table").DataTable({
						order: [0, 'desc']
					});
				}
			});
		}

		// Delete a Note of an admin Ajax Request
	    $("body").on('click', '.dltBtn', function(event) {
	      event.preventDefault();
	      
	      note_id = $(this).attr('id');
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
	            data: {note_id: note_id},
	            success:function(response){
	              Swal.fire(
	                'Deleted!',
	                'Note has been deleted succesfully.',
	                'success'
	              )
	              fetchAllNotes();
	            }
	          });
	        }
	      });

	    });

	});
</script>

</body>
</html>