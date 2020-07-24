<?php
	session_start();
	if( isset($_SESSION['user']) ){
		header('location:home.php');
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>AFILIACIONES</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/index.css">
</head>
<body>

	
<div class="container">
	<!-- Login from Start -->
	<div class="row justify-content-center wrapper" id="login-box">
		<div class="col-lg-10 my-auto">
			<div class="card-group myShadow">
				<div class="card rounder-left p-4" style="flex-grow: 1.4">
					<h1 class="text-center font-weight-bold text-primary">Inicia Sesión</h1>
					<hr class="my-3">
					<!-- Formulario de iniciar Session -->
					
					<form action="" method="post" id="login-form" class="px-3">
						<div id="loginAlerta"></div>

						<div class="input-group input-group-lg form-group">
							<span class="input-group-text rounder-0">
								<i class="fas fa-envelope fa-lg"></i>
							</span>
							<input type="email" name="email" id="email" class="form-control rounder-0" placeholder="Ingresa tu correo electronico" required>
						</div>

						<div class="input-group input-group-lg form-group">
							<span class="input-group-text rounder-0">
								<i class="fas fa-key fa-lg"></i>
							</span>
							<input type="password" name="password" id="password" class="form-control rounder-0" placeholder="Ingrese su contraseña" required>
						</div>

						<div class="form-group">
							<div class="form-group float-right">
								<a href="#" id="forgot-link">¿Olvidaste tu contraseña?</a>
							</div>
							<div class="clearfix"></div>
						</div>
						<div class="form-group">
							<input type="submit" value="Iniciar Session" id="login-btn" class="btn btn-primary btn-lg btn-block myBtn">
						</div>

					</form>
					
				</div>
				<div class="card justify-content-center rounder-right myColor p-4">
					<h1 class="text-center font-weight-bold text-light">¡¡Bienvenidos!!</h1>
					<hr class="my-3 bg-light myHr">
					<p class="text-center font-weight-bold text-light lead">
						Ingresa con tu correo y contraseña personal para ingresar al sistema.
					</p>
					<button class="btn btn-outline-light btn-lg align-self-center font-weight-bold mt-4 myLinkBtn" id="register-link">Registrate!</button>
				</div>

			</div>
		</div>
	</div>
	<!-- Login Form End -->
	
	<div class="row justify-content-center wrapper" id="register-box" style="display: none">
		<div class="col-lg-10 my-auto">
			<div class="card-group myShadow">
				<div class="card justify-content-center rounder-left myColor p-4">
					<h1 class="text-center font-weight-bold text-light">Bienvenido</h1>
					<hr class="my-3 bg-light myHr">
					<p class="text-center font-weight-bold text-light lead">
						Para ver nuestros futuros evento por favor ingresa con tu correo y contraseña
					</p>
					<button class="btn btn-outline-light btn-lg align-self-center font-weight-bolder mt-4 myLinkBtn" id="login-link">Ingresar</button>
				</div>
				<div class="card rounder-right p-4" style="flex-grow: 1.4;">
					<h1 class="text-center font-weight-bold text-primary">Crear Cuenta</h1>
					<hr class="my-3">
					<form action="" method="post" class="px-3" id="register-form">
						<div id="registroAlerta"></div>

						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="far fa-user fa-lg"></i>
								</span>
							</div>
							<input type="text" name="name" id="name" class="form-control rounder-0" placeholder="Nombre" required >
						</div>
						
						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="far fa-envelope fa-lg"></i>
								</span>
							</div>
							<input type="email" name="email" id="remail" class="form-control rounder-0" placeholder="E-mail" required >
						</div>

						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="fas fa-key fa-lg"></i>
								</span>
							</div>
							<input type="password" name="password" id="rpassword" class="form-control rounder-0" placeholder="password" required minlength="5">
						</div>

						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="fas fa-key fa-lg"></i>
								</span>
							</div>
							<input type="password" name="rpassword" id="cpassword" class="form-control rounder-0" placeholder="Confirm password" required minlength="5">
						</div>

						<div class="input-group input-group-lg form-group">
							<div class="input-group-prepend">
								<span class="input-group-text rounder-0">
									<i class="far fa-id-card fa-lg"></i>
								</span>
							</div>
							<input type="text" name="curp" id="curp" class="form-control rounder-0" placeholder="CURP" required >
						</div>

						<div class="form-group">
							<div class="text-danger font-weight-bold" id="passError" ></div>
						</div>

						<div class="form-group">
							<input type="submit" value="Registrar" id="register-btn" class="btn btn-primary btn-lg btn-block myBtn">
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>

</div>



<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.bundle.min.js.map"></script> -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<!-- <script type="text/javascript" src="assets/js/index.js"></script> -->

<script type="text/javascript">
$(document).ready(function(){

	$("#register-link").click(function(){
		$("#login-box").hide();
		$('#register-box').show();
	});

	$("#login-link").click(function(){
		$('#login-box').show();
		$('#register-box').hide();
	});

	//Register Ajax Request
	$('#register-btn').click(function(e){
		if( $('#register-form')[0].checkValidity() ){
			e.preventDefault();
			$('#registroAlerta').val('');
			$('#register-btn').val('Procesando..........');
			if( $('#rpassword').val() != $('#cpassword').val() ){
				$('#passError').text('* Ooops las contraseñas no coinciden!!');
				$('#register-btn').val('Registrar');
			}else{
				$('#registroAlerta').val('');
				///Ajax request
				$.ajax({
					url : 'assets/php/action.php',
					method: 'post',
					data: $('#register-form').serialize()+'&action=registrar',
					success:function(response){
						if(response==='register'){
							window.location = 'home.php';
						}else{
							$('#registroAlerta').html(response);
							$('#register-btn').val('Registrar');
						}
					}
				});

			}
		}else{
			$('#registroAlerta').html('<b>Todos los campos son requeridos</b><br><br>');
		}
	});

	//Login Ajax Request
	$('#login-btn').click(function(e){
		if( $('#login-form')[0].checkValidity() ){
			e.preventDefault();
			$('#login-btn').val('Validando datos..........');
			//Ajax request
			$.ajax({
				url : 'assets/php/action.php',
				method : 'post',
				data: $('#login-form').serialize()+'&action=login',
				success:function(response){
					$('#login-btn').val('Iniciar Session');
					if( response === 'login' ){
						window.location = 'home.php';
					}else{
						$('#loginAlerta').html(response);
						$('#login-btn').val('Iniciar Session');
					}
				}
			});
		}else{
			$('#loginAlerta').html('<b>Todos los campos son requeridos</b><br><br>');
		}
		
	});

});
</script>

</body>
</html>