<?php

	session_start();
	require_once "auth.php";

	$cuser = new Auth();

	if( !isset($_SESSION['user']) ){
		header('location:index.php');
		die();
	}

	$cemail = $_SESSION['user'];

	$data = $cuser->currentUser($cemail);
	//cid = id del usuario
	$cid = $data['id'];
	//cname nombre del usuario
	$cname = $data['name'];
	//contraseña del usuario
	$cpass = $data['password'];
	//numero del padre
	$cfatherphone = $data['father_phone'];
	//telefono del afiliado
	$cphone = $data['phone'];
	//genero
	$cgender = $data['gender'];
	//dia de nacimiento
	$cdob = $data['dob'];
	//foto del deportista
	$cphoto = $data['photo'];
	//curp del deportista
	$ccurp = $data['curp'];
	//acta de nacimiento del deportista ruta
	$cacta = $data['acta'];
	//comprobante de pago del deportista ruta
	$ccomprobante = $data['comprobante'];
	//fecha de creacion
	$created = $data['created_at'];
	//verificado
	$verified = $data['verified'];

	//registrado desde
	$reg_on = date('d M Y',strtotime($created));

	$fname = strtok($cname, " ");

	//mostrar si esta verificado o no
	if($verified == 0){
		$verified = 'No verificado';
	}else{
		$verified = 'Verificado';
	}


?>