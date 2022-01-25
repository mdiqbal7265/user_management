<?php
	session_start();
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	
	//Load Composer's autoloader
	require 'vendor/autoload.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);

	include 'auth.php';
	$user = new Auth();

	// Handle Register Form
	if(isset($_POST['action']) && $_POST['action'] == 'register'){
		$name = $user->test_input($_POST['name']);
		$email = $user->test_input($_POST['email']);
		$pass = $user->test_input($_POST['password']);

		$hpass = password_hash($pass, PASSWORD_DEFAULT);

		if($user->user_exists($email)){
			echo $user->showMessage('danger','This email is already registered!');
		}else{
			if($user->register($name,$email,$hpass)){
				echo 'register';
				$_SESSION['user'] = $email;
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
			}else{
				echo $user->showMessage('danger','Something went wrong! try again later!');
			}
		}
	}

	// Handle Login Form

	if(isset($_POST['action']) && $_POST['action'] == 'login'){
		$email = $user->test_input($_POST['email']);
		$password = $user->test_input($_POST['password']);

		$loggedInUser = $user->login($email);

		if($loggedInUser != null){
			if(password_verify($password, $loggedInUser['password'])){
				if(!empty($_POST['rem'])){
					setcookie("email", $email, time()+(30*24*60*60), '/');
					setcookie("password", $password, time()+(30*24*60*60), '/');
				}else{
					setcookie("email","",1,"/");
					setcookie("password","",1,"/");
				}

				echo 'login';
				$_SESSION['user'] = $email;
			}else{
				echo $user->showMessage('danger','Password didn\'t match with your email!');
			}
		}else{
			echo $user->showMessage('danger','We didn\'t find your email in our database!');
		}
	}

	// Handle Forgot Pasword

	if(isset($_POST['action']) && $_POST['action'] == 'forgot'){
		$email = $user->test_input($_POST['email']);

		$user_found = $user->currentUser($email);

		if ($user_found != null) {
			$token = uniqid();
			$token = str_shuffle($token);

			$user->forgotPassword($token, $email);

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
				$mail->Subject = 'Reset Password';
				$mail->Body = '<h3>Click the below link to reset your password. <br><a href="http://localhost:3030/reset-pass.php?email='.$email.'&token='.$token.'">Reset Password <br>http://localhost:3030/reset-pass.php?email='.$email.'&token='.$token.'</a><br>Regards<br>Md Iqbal</h3>';
				$mail->send();

				echo $user->showMessage('success','We have send you the reset link in your e-mail ID, please check your e-mail!');
			} catch (Exception $e) {
				echo $user->showMessage('danger','Something went wrong. Please try again later!'."Error: {$mail->ErrorInfo}");
			}
		}else{
			echo $user->showMessage('danger','Your email didn\'t find in our database. Please Input your correct email and try again later!');
		}
	}

	// Check user is logged in or not
	if(isset($_POST['action']) && $_POST['action'] == 'checkUser'){
		if(!$user->currentUser($_SESSION['user'])){
			echo 'bye';
			unset($_SESSION['user']);
		}
	}
?>