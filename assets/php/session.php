<?php 
	
	session_start();
	require_once 'auth.php';
	$cuser = new Auth();

	if(!isset($_SESSION['user'])){
		header("location:index.php");
		die();
	}

	$cemail = $_SESSION['user'];
	$data = $cuser->currentUser($cemail);

	$id = $data['id'];
	$name = $data['name'];
	$pass = $data['password'];
	$email = $data['email'];
	$gender = $data['gender'];
	$phone = $data['phone'];
	$dob = $data['dob'];
	$photo = $data['photo'];
	$created = $data['created_at'];
	$created = date('d M Y', strtotime($created));
	$verified = $data['verified'];

	$fname = strtok($name, " ");

	if($verified == 0){
		$verified = 'Not Verified!';
	}else{
		$verified = 'Verified!';
	}
	
?>