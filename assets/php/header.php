<?php
	require_once "session.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title> <?= ucfirst(basename($_SERVER['PHP_SELF'],'.php')); ?> |Emmanuel </title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.css"/> 
	</style>
</head>
<body>

<nav class="navbar navbar-expand-md bg-dark navbar-dark">
	<!-- Brand -->
  	<a class="navbar-brand" href="index.php"><i class="fas fa-code fa-lg"></i>&nbsp;&nbsp;Afiliación</a>
  	<!-- Toggler/collapsibe Button -->
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    	<span class="navbar-toggler-icon"></span>
  	</button>
  	<!-- Navbar links -->
  	<div class="collapse navbar-collapse" id="collapsibleNavbar">
    	<ul class="navbar-nav ml-auto">
      		<li class="nav-item">
        		<a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "home.php" ? "active" : "" ) ?> " href="home.php"><i class="fas fa-home"></i>&nbsp;Home</a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "profile.php" ? "active" : "" ) ?> " href="profile.php"><i class="fas fa-user-circle"></i>&nbsp;Perfil</a>
      		</li>
      		<li class="nav-item">
        		<a class="nav-link <?= (basename($_SERVER['PHP_SELF']) == "feedback.php" ? "active" : "" ) ?> " href="feedback.php"><i class="fas fa-comment-dots"></i>&nbsp;Feedback</a>
      		</li>
      		<li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == "notification.php" ? "active" : "" ) ?> ">
        		<a class="nav-link" href="notification.php"><i class="fas fa-bell"></i>&nbsp;Notificaciones&nbsp;<span id="checkNotification"></span></a>
      		</li>
          <li class="nav-item <?= (basename($_SERVER['PHP_SELF']) == "eventos.php" ? "active" : "" ) ?> ">
            <a class="nav-link" href="eventos.php"><i class="fas fa-calendar"></i>&nbsp;Eventos&nbsp;</a>
          </li>

		    <li class="nav-item dropdown">
		    	<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
		        	<i class="fas fa-user-cog"></i>&nbsp;Hi! <?= $fname; ?>
		      	</a>
		      	<div class="dropdown-menu">
      				<a href="#" class="dropdown-item"><i class="fas fa-cog"></i>&nbsp;Ajustes</a>
      				<a href="assets/php/logout.php" class="dropdown-item"><i class="fas fa-sign-out-alt"></i>&nbsp;Cerrar Sesión</a>
		      	</div>
		    </li>

    	</ul>
  	</div>
</nav>