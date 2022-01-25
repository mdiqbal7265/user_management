<?php 

	require_once 'session.php';

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	//Load Composer's autoloader
	require 'vendor/autoload.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	// Handle Add Note ajax request
	if (isset($_POST['action']) && $_POST['action'] == 'add_note') {
		$title = $cuser->test_input($_POST['title']);
		$note = $cuser->test_input($_POST['note']);

		$add = $cuser->addNewNote($id,$title,$note);
		if ($add == true) {
			$cuser->notification($id,'admin','Note Added');
			echo 'success';
		}
	}

	// Handle Diplay Notes

	if(isset($_POST['action']) && $_POST['action'] == 'display_notes'){
		$output = '';

		$notes = $cuser->getNotes($id);
		if($notes){
			$output .= '<table class="table table-striped text-center">
            <thead>
              <tr>
                <th>#</th>
                <th>Title</th>
                <th>Note</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>';

            foreach ($notes as $value) {
             	$output .= '<tr>
                <td>'.$value['id'].'</td>
                <td>'.$value['title'].'</td>
                <td>'.substr($value['notes'], 0,75).'...</td>
                <td>
                  <a href="#" id="'.$value['id'].'" title="View Details" class="text-success infoBtn"><i class="fas fa-info-circle fa-lg"></i></a>&nbsp;

                   <a href="#" id="'.$value['id'].'" title="Edit Note" class="text-primary editBtn"><i class="fas fa-edit fa-lg" data-toggle="modal" data-target="#editNoteModal"></i></a>&nbsp;

                   <a href="#" id="'.$value['id'].'" title="Delete Note" class="text-danger dltBtn"><i class="fas fa-trash-alt fa-lg"></i></a>
                </td>
              </tr>';
             }

             $output .=  '</tbody></table>';

             echo $output;
		}else{
			echo '<h3 class="text-center text-secondary">:( You have not written any note yet! Write your first note now!)</h3>';
		}
	}

	// Handle Edit Note of an user
	if(isset($_POST['edit_id'])){
		$id = $_POST['edit_id'];

		$row = $cuser->editNote($id);
		echo json_encode($row);
	}	

	// Handle Update Note
	if (isset($_POST['action']) && $_POST['action'] == 'update_note') {
		$id = $cuser->test_input($_POST['id']);
		$title = $cuser->test_input($_POST['title']);
		$notes = $cuser->test_input($_POST['notes']);

		$update = $cuser->updateNote($id, $title, $notes);
		if($update == true){
			$cuser->notification($id,'admin','Note Updated');
			echo 'updated';
		}
	}

	// Handle Delete a note

	if(isset($_POST['del_id'])){
		$id = $_POST['del_id'];

		$cuser->deleteNote($id);
		$cuser->notification($id,'admin','Note Deleted');
	}


	//Handle Show note by a single user
	if (isset($_POST['info_id'])) {
		$id = $_POST['info_id'];

		$row = $cuser->editNote($id);

		echo json_encode($row);
	}

	// Handle Profile Update 
	if(isset($_FILES['image'])){
		$name = $cuser->test_input($_POST['name']);
		$gender = $cuser->test_input($_POST['gender']);
		$dob = $cuser->test_input($_POST['dob']);
		$phone = $cuser->test_input($_POST['phone']);

		$oldImage = $_POST['oldimage'];
		$folder = '../img/';

		if (isset($_FILES['image']['name']) && ($_FILES['image']['name'] != "")) {
			$upload_path = $folder.$_FILES['image']['name'];
			$newimage = $_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'], $upload_path);

			if($oldImage != null){
				unlink($oldImage);
			}
		}else{
			$newimage = $oldImage;
		}

		$cuser->updateProfile($name,$gender,$dob,$phone,$newimage,$id);
		$cuser->notification($id,'admin','Profile Updated');
	}


	// Handle change password
	if (isset($_POST['action']) && $_POST['action'] == 'change_pass') {
		$currpass = $_POST['curpass'];
		$newpass  = $_POST['newpass'];
		$cnewpass = $_POST['cnewpass'];

		$hpass = password_hash($newpass, PASSWORD_DEFAULT);

		if($newpass != $cnewpass){
			echo $cuser->showMessage('danger','Password did not matched!');
		}else{
			if(password_verify($currpass, $pass)){
				$cuser->chnagePassword($hpass, $id);
				echo $cuser->showMessage('success','Password chnaged succesfully!');
				$cuser->notification($id,'admin','Password Changed');
			}else{
				echo $cuser->showMessage('danger','Current Password is Wrong!');
			}
		}
	}

	// Handle Verify Email

	if(isset($_POST['action']) && $_POST['action'] == 'verify_email'){
		try {
			$mail->isSMTP();
			$mail->Host = 'smtp.mailtrap.io';
			$mail->SMTPAuth = true;
			$mail->Port = 2525;
			$mail->Username = 'ef4113ce44efb0';
			$mail->Password = 'a0aff7124fdd5f';
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

			$mail->setFrom('admin@gmail.com','MD Iqbal Hossen');
			$mail->addAddress($email);
			$mail->isHTML(true);
			$mail->Subject = 'Verify E-Mail';
			$mail->Body = '<h3>Click the below link to Verify Your E-mail. <br><a href="http://localhost:3030/verify-email.php?email='.$email.'">Verify Email <br>http://localhost:3030/reset-pass.php?email='.$email.'</a><br>Regards<br>Md Iqbal</h3>';
			$mail->send();

			echo $cuser->showMessage('success','Verification link sent to your E-mail. Please Check your mail!!');
		} catch (Exception $e) {
			echo $cuser->showMessage('danger','Something went wrong. Please try again later!'."Error: {$mail->ErrorInfo}");
		}
	}

	// Handle Send Feedback by an user to admin
	if(isset($_POST['action']) && $_POST['action'] == 'feedback'){
		$subject = $cuser->test_input($_POST['subject']);
		$feedback = $cuser->test_input($_POST['feedback']);

		$cuser->sendFeedback($subject,$feedback,$id);
		$cuser->notification($id,'admin','Feedback Send');
	}

	// Handle Fetch Notifications

	if(isset($_POST['action']) && $_POST['action'] == 'fetchNotification'){
		$notification = $cuser->fetchNotification($id);
		$output = '';

		if($notification){
			foreach ($notification as $row) {
				$output .= '<div class="alert alert-danger" role="alert">
										<button class="close" id="'.$row['id'].'" type="button" data-dismiss="alert" aria-label="close">
											<span aria-hidden="true">&times;</span>
										</button>
										<h4 class="alert-heading">New Notifications</h4>
										<p class="mb-0 lead">'.$row['message'].'</p>
										<hr class="my-2">
										<p class="mb-0 float-left">Reply of feedback from admin</p>
										<p class="mb-0 float-right">'.$cuser->timeAgo($row['created_at']).'</p>
										<div class="clearfix"></div>
									</div>';
			}

			echo $output;
		}else{
			echo '<h3 class="text-center text-secondary mt-5">No any new notification.</h3>';
		}
	}

	// Check Notifications

	if(isset($_POST['action']) && $_POST['action'] == 'checkNotification'){
		if($cuser->fetchNotification($id)){
			echo '<i class="fas fa-circle fa-sm text-danger"></i>';
		}else{
			echo '';
		}
	}

	// Remove Notification
	if (isset($_POST['notification_id'])) {
		$id = $_POST['notification_id'];
		$cuser->removeNotification($id);
	}

 ?>