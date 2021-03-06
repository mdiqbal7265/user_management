<?php 
	require_once 'assets/php/session.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= ucfirst(basename($_SERVER['PHP_SELF'],'.php')); ?> | User Management System</title>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.1/css/bootstrap.min.css"/>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.3/datatables.min.css"/>
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css2?family=Maven+Pro:wght@400;500;600;700;800;900&family=Ubuntu:wght@700&display=swap');
		*{
			font-family: 'Maven Pro', sans-serif;
		}
	</style>
</head>
<body>

<!-- navbar -->
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
  <!-- Brand -->
  <a class="navbar-brand" href="home.php"><i class="fas fa-code fa-lg"></i>&nbsp;&nbsp;User Management</a>

  <!-- Toggler/collapsibe Button -->
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>

  <!-- Navbar links -->
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "home.php")?"active":""; ?>" href="home.php"><i class="fas fa-home"></i>&nbsp;Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "profile.php")?"active":""; ?>" href="profile.php"><i class="fas fa-user-circle"></i>&nbsp;Profile</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "feedback.php")?"active":""; ?>" href="feedback.php"><i class="fas fa-comment-dots"></i>&nbsp;Feedback</a>
      </li>
      <li class="nav-item">
        <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "notifications.php")?"active":""; ?>" href="notifications.php"><i class="fas fa-bell"></i>&nbsp;Notification&nbsp;<span id="checkNotification"></span> </a>
      </li>
      <li class="nav-item dropdown">
      	<a href="#" class="nav-link dropdown-toggle" id="navbardrop" data-toggle="dropdown">
      		<i class="fas fa-user-cog"></i>&nbsp;Hi! <?= $fname; ?>
      	</a>
      	<div class="dropdown-menu">
      		<a href="#" class="dropdown-item"><i class="fas fa-cog"></i>&nbsp; Setting</a>
      		<a href="assets/php/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>&nbsp; Logout</a>
      	</div>
      </li>
    </ul>
  </div>
</nav>
<!-- Navbar end -->