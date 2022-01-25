<?php 

require 'admin_db.php';

$admin = new Admin();
session_start();

// Handle Admin Login

if (isset($_POST['action']) && $_POST['action'] == 'admin_login') {
	
	$username = $admin->test_input($_POST['username']);
	$password = $admin->test_input($_POST['password']);

	$h_password = sha1($password);

	$loggedInAdmin = $admin->admin_login($username,$h_password);

	if ($loggedInAdmin != null) {
		echo 'admin_login';
		$_SESSION['username'] = $username;
	}else {
		echo $admin->showMessage('danger','Username or password is Incorrect!');
	}
}

// Handle Fetch All User
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllUsers'){
	$output = '';
	$data = $admin->fetchAllUsers(0);
	$path = '../assets/img/';

	if ($data) {
		$output .= '<table class="table table-striped text-center table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Verified</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($data as $value) {
            	if($value['photo'] != ''){
            		$uphoto = $path.$value['photo'];
            	}else{
            		$uphoto = '../assets/img/avater.png';
            	}
            	if($value['verified'] == 1){
            		$verified = '<span class="badge badge-success">Verified</span>';
            	}else{
            		$varified = '<span class="badge badge-danger">Unverified</span>';
            	}
             	$output .= '<tr>
                <td>'.$value['id'].'</td>
                <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"></td>
                <td>'.$value['name'].'</td>
                <td>'.$value['email'].'</td>
                <td>'.$value['phone'].'</td>
                <td>'.$value['gender'].'</td>
                <td>'.$verified.'</td>
                <td>
                  <a href="#" id="'.$value['id'].'" title="View Details" class="text-info infoBtn" data-toggle="modal" data-target="#showUserDetailsModal"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

                   <a href="#" id="'.$value['id'].'" title="Delete User" class="text-danger dltBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
                </td>
              </tr>';
             }

             $output .=  '</tbody></table>';

             echo $output;
	}else{
		echo '<h3 class="text-secondary text-center">:( No any user registered yet!</h3>';
	}
}


// Handle Display User By ID

if(isset($_POST['id'])){
	$id = $_POST['id'];

	$data = $admin->fetchUserDetailsById($id);

	echo json_encode($data);

}

// Handle Delete an user
if(isset($_POST['del_id'])){
	$id = $_POST['del_id'];

	$admin->userAction($id,0);
}


// Handle Fetch All Deleted User Ajax Request
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllDeletedUsers'){
	$output = '';
	$data = $admin->fetchAllUsers(1);
	$path = '../assets/img/';

	if ($data) {
		$output .= '<table class="table table-striped text-center table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>E-mail</th>
                <th>Phone</th>
                <th>Gender</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($data as $value) {
            	if($value['photo'] != ''){
            		$uphoto = $path.$value['photo'];
            	}else{
            		$uphoto = '../assets/img/avater.png';
            	}
            	if($value['verified'] == 1){
            		$verified = '<span class="badge badge-success">Verified</span>';
            	}else{
            		$varified = '<span class="badge badge-danger">Unverified</span>';
            	}
             	$output .= '<tr>
                <td>'.$value['id'].'</td>
                <td><img src="'.$uphoto.'" class="rounded-circle" width="40px"></td>
                <td>'.$value['name'].'</td>
                <td>'.$value['email'].'</td>
                <td>'.$value['phone'].'</td>
                <td>'.$value['gender'].'</td>
                <td>
                   <a href="#" id="'.$value['id'].'" title="Restore User" class="text-white restoreBtn btn btn-danger"><i class="fa fa-arrow-rotate-left fa-lg"></i></a>
                </td>
              </tr>';
             }

             $output .=  '</tbody></table>';

             echo $output;
	}else{
		echo '<h3 class="text-secondary text-center">:( No any Deleted user registered yet!</h3>';
	}
}


// Handle Restore Deleted User
if(isset($_POST['restore_id'])){
	$id = $_POST['restore_id'];

	$admin->userAction($id,1);
}

// Handle Fetch All Notes
if(isset($_POST['action']) && $_POST['action'] == 'fetchAllNotes'){
  $output = '';
  $data = $admin->fetchAllNotes();

  if ($data) {
    $output .= '<table class="table table-striped text-center table-bordered">
            <thead>
              <tr>
                <th>#</th>
                <th>User Name</th>
                <th>User e-mail</th>
                <th>Title</th>
                <th>Note</th>
                <th>Written On</th>
                <th>Updated On</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($data as $value) {
              $output .= '<tr>
                <td>'.$value['id'].'</td>
                <td>'.$value['name'].'</td>
                <td>'.$value['email'].'</td>
                <td>'.$value['title'].'</td>
                <td>'.substr($value['notes'], 0,75).'...</td>
                <td>'.$value['created_at'].'</td>
                <td>'.$value['updated_at'].'</td>
                <td>
                   <a href="#" id="'.$value['id'].'" title="Delete Note" class="text-danger dltBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
                </td>
              </tr>';
             }

             $output .=  '</tbody></table>';

             echo $output;
  }else{
    echo '<h3 class="text-secondary text-center">:( No any Note Written yet!</h3>';
  }
}

// Handle Delete note of an use by admin

if(isset($_POST['note_id'])){
  $id = $_POST['note_id'];

  $admin->deleteNote($id);
}

// Handle fetch all feedback

if(isset($_POST['action']) && $_POST['action'] == 'fetchAllFeedback'){
  $output = '';
  $data = $admin->fetchFeedback();

  if ($data) {
    $output .= '<table class="table table-striped text-center table-bordered">
            <thead>
              <tr>
                <th>FID</th>
                <th>UID</th>
                <th>User name</th>
                <th>User e-mail</th>
                <th>Subject</th>
                <th>Feedback</th>
                <th>Send On</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($data as $value) {
              $output .= '<tr>
                <td>'.$value['id'].'</td>
                <td>'.$value['uid'].'</td>
                <td>'.$value['name'].'</td>
                <td>'.$value['email'].'</td>
                <td>'.$value['subject'].'</td>
                <td>'.substr($value['feedback'], 0,75).'...</td>
                <td>'.$value['created_at'].'</td>
                <td>
                   <a href="#" fid="'.$value['id'].'" id="'.$value['uid'].'" title="Reply" data-toggle="modal" data-target="#showReplyModal" class="text-dark replyBtn"><i class="fas fa-reply fa-lg"></i></a>
                </td>
              </tr>';
             }

             $output .=  '</tbody></table>';

             echo $output;
  }else{
    echo '<h3 class="text-secondary text-center">:( No any Feedback Written yet!</h3>';
  }
}

// Handle Reply Feedback to user 
if (isset($_POST['message'])) {
  $uid = $_POST['uid'];
  $message = $admin->test_input($_POST['message']);
  $fid = $_POST['fid'];

  $admin->replyFeedback($uid, $message);
  $admin->feedbackReplied($fid);
}

// Handle fetchNotofication 
  if(isset($_POST['action']) && $_POST['action'] == 'fetchNotofication'){
    $notification = $admin->fetchNotofication();
    $output = '';

    if($notification){
      foreach ($notification as $row) {
        $output .= '<div class="alert alert-info" role="alert">
                    <button class="close" id="'.$row['id'].'" type="button" data-dismiss="alert" aria-label="close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="alert-heading">New Notifications</h4>
                    <p class="mb-0 lead">'.$row['message'].' by '.$row['name'].'</p>
                    <hr class="my-2">
                    <p class="mb-0 float-left"><b> User E-Mail:</b> '.$row['email'].'</p>
                    <p class="mb-0 float-right">'.$admin->timeAgo($row['created_at']).'</p>
                    <div class="clearfix"></div>
                  </div>';
      }

      echo $output;
    }else{
      echo '<h3 class="text-center text-secondary mt-5">No any new notification.</h3>';
    }
  }

  // Handle Check Notification
  if(isset($_POST['action']) && $_POST['action'] == 'checkNotification'){
    if($admin->fetchNotofication()){
      echo '<i class="fas fa-circle fa-sm text-danger"></i>';
    }else{
      echo '';
    }
  }

  // Remove Notification
  if (isset($_POST['notification_id'])) {
    $id = $_POST['notification_id'];
    $admin->removeNotification($id);
  }

  // Handle Export All User
  if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=users.xls");
    header("Pragma: no-cache");
    header("Expires: 0");

    $data = $admin->exportAllUser();
    echo '<table border="1" align="center">';

    echo '<tr>
            <th>#</th>
            <th>Name</th>
            <th>E-Mail</th>
            <th>Phone</th>
            <th>Gender</th>
            <th>DOB</th>
            <th>Joined On</th>
            <th>Verified</th>
            <th>Deleted</th>
          </tr>';
    foreach ($data as $row) {
      echo '<tr>
              <td>'.$row['id'].'</td>
              <td>'.$row['name'].'</td>
              <td>'.$row['email'].'</td>
              <td>'.$row['phone'].'</td>
              <td>'.$row['gender'].'</td>
              <td>'.$row['dob'].'</td>
              <td>'.$row['created_at'].'</td>
              <td>'.$row['verified'].'</td>
              <td>'.$row['deleted'].'</td>
            </tr>';
    }

    echo '</table>';

  }
 ?>