<?php require_once "assets/php/header.php"; ?>


  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <?php if($verified == 'Not Verified!'): ?>
          <div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
            <button class="close" type="button" data-dismiss="alert">&times;</button>
            <strong>Your E-Mail is not verified! We've sent you an E-Mail Verification link on your E-mail, check & Verify now!</strong>
          </div>
        <?php endif; ?>
        <h4 class="text-center text-primary mt-2">Write Your Notes Here & Access Anytime Anywhere!</h4>
      </div>
    </div>
    <div class="card border-primary">
      <h5 class="card-header bg-primary d-flex justify-content-between">
        <span class="text-light lead align-self-center">All Notes</span>
        <a href="#" class="btn btn-light" data-toggle="modal" data-target="#addNoteModal"><i class="fas fa-plus-circle fa-lg"></i>&nbsp;Add New Note</a>
      </h5>
      <div class="card-body">
        <div class="table-responsive" id="showNote">
          <p class="text-center lead mt-5">Please Wait...</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal Add New Note -->
  <div class="modal fade" id="addNoteModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-success">
          <h4 class="modal-title text-light">Add New Note</h4>
          <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="#" method="post" id="addnote_form" class="px-3">
            <div class="form-group">
              <input type="text" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
            </div>
            <div class="form-group">
              <textarea name="note" class="form-control form-control-lg" placeholder="Write your note here..." rows="6" required></textarea>
            </div>
            <div class="form-group">
              <input type="submit" name="addNote" id="addnote_btn" value="Add Note" class="btn btn-success btn-block btn-lg">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Edit Note -->

  <!-- Modal Add New Note -->
  <div class="modal fade" id="editNoteModal">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title text-light">Edit Note</h4>
          <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <form action="#" method="post" id="editnote_form" class="px-3">
            <input type="hidden" name="id" id="id">
            <div class="form-group">
              <input type="text" id="title" name="title" class="form-control form-control-lg" placeholder="Enter Title" required>
            </div>
            <div class="form-group">
              <textarea name="notes" id="notes" class="form-control form-control-lg" placeholder="Write your note here..." rows="6" required></textarea>
            </div>
            <div class="form-group">
              <input type="submit" name="editNote" id="editnote_btn" value="Edit Note" class="btn btn-info btn-block btn-lg">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Edit Note -->


<!-- Scripts -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript">
  $(document).ready(function() {
    

    // Add New Note Ajax Request

    $("#addnote_btn").click(function(e) {
      if($("#addnote_form")[0].checkValidity()){
        e.preventDefault();

        $("#addnote_btn").val('Please Wait.....');

        $.ajax({
          url: 'assets/php/process.php',
          type: 'POST',
          data: $("#addnote_form").serialize()+'&action=add_note',
          success:function(response){
            $("#addnote_btn").val('Add Note');
            $("#addnote_form")[0].reset();
            $("#addNoteModal").modal('hide');
            if(response == 'success'){
              Swal.fire({
              title: 'Note added Succesfully!',
              type: 'success'
            });
              displayAllNote();
            }else{
              Swal.fire({
              title: 'Something Went Wrong!',
              type: 'danger'
            });
              displayAllNote();
            }
          }
        });       
      }
    });

    // Edit Note of an user Ajax Requests
    $("body").on('click', '.editBtn', function(e) {
      e.preventDefault();
      edit_id = $(this).attr('id');
      $.ajax({
        url: 'assets/php/process.php',
        type: 'POST',
        data: {edit_id: edit_id},
        success:function(response){
          data = JSON.parse(response);
          $("#id").val(data.id);
          $("#title").val(data.title);
          $("#notes").val(data.notes);
        }
      });      
    });

    // Update Note Ajax Request
    $("#editnote_btn").click(function(event) {
      if($("#editnote_form")[0].checkValidity()){
        event.preventDefault();

        $("#editnote_btn").val('Please Wait.....');
        $.ajax({
          url: 'assets/php/process.php',
          type: 'POST',
          data: $("#editnote_form").serialize()+"&action=update_note",
          success:function(response){
            $("#editnote_btn").val('Update Note');
            $("#editnote_form")[0].reset();
            $("#editNoteModal").modal('hide');
            if(response == 'updated'){
              Swal.fire({
              title: 'Note Updated Succesfully!',
              type: 'success'
            });
              displayAllNote();
            }else{
              Swal.fire({
              title: 'Something Went Wrong!',
              type: 'danger'
            });
              displayAllNote();
            }
          }
        });        
      }
    });

    // Delete a Note of an user Ajax Request
    $("body").on('click', '.dltBtn', function(event) {
      event.preventDefault();
      
      del_id = $(this).attr('id');
      Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.value) {
          $.ajax({
            url: 'assets/php/process.php',
            type: 'POST',
            data: {del_id: del_id},
            success:function(response){
              Swal.fire(
                'Deleted!',
                'Your Note has been deleted succesfully.',
                'success'
              )
              displayAllNote();
            }
          });
        }
      });

    });

    //Show Note of an single user
    $("body").on('click', '.infoBtn', function(event) {
      event.preventDefault();
      
      info_id = $(this).attr('id');

      $.ajax({
        url: 'assets/php/process.php',
        type: 'POST',
        data: {info_id: info_id},
        success:function(response) {
          data = JSON.parse(response);
          Swal.fire({
            title: '<strong>Note: ID('+data.id+')</strong>',
            type: 'info',
            html: '<b>Title : </b>'+data.title+'<br><br><b>Note : </b>'+data.notes+'<br><br><b>Written On : </b>'+data.created_at+'<br><br><b>Updated On : </b>'+data.updated_at,
            showCloseButton: true,
          })
        }
      });
      
    });


    displayAllNote();
    // Display all note an user
    function displayAllNote(){
      $.ajax({
        url: 'assets/php/process.php',
        type: 'POST',
        data: {action: 'display_notes'},
        success:function(response){
          $("#showNote").html(response);
          $(".table").DataTable({
            order: [0,'desc']
          });
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

    // Checked user is logged in or not
    $.ajax({
      url: 'assets/php/action.php',
      type: 'post',
      data: {action: 'checkUser'},
      success:function(response){
        if(response == 'bye'){
          window.location = 'index.php';
        }
      }
    });
    

  });
</script>
</body>
</html>