<?php

	/*
		Este es el archivo de accion al cual el Js se comunicara
		y este a su vez heredara de Auth que tiene las funciones para 
		las acciones que se requieran realizar
	*/
	session_start();
	require_once "auth.php";
	$user = new Auth();

	//Registrar un usuario en la base de datos
	if( isset($_POST['action']) && $_POST['action'] === 'registrar' ){
		$name = $user->limpiar_input($_POST['name']);
		$email = $user->limpiar_input($_POST['email']);
		$password = $user->limpiar_input($_POST['password']);
		$curp = $user->limpiar_input($_POST['curp']);
		//Validacion de cada uno de los datos
		if( $name === "" ){
			echo $user->mostrar_alerta("warning", "el campo nombre es requerido");
			die();
		}
		if( $email === ""){
			echo $user->mostrar_alerta("warning", "el campo email es requerido");
			die();
		}
		if( $password === "" ){
			echo $user->mostrar_alerta("warning", "el campo password es requerido");
			die();
		}
		if( $curp === '' ){
			echo $user->mostrar_alerta("warning", "el campo curp es requerido");
			die();
		}
		$hpassword = password_hash($password, PASSWORD_DEFAULT);
		//Validacion que el email no exista en DB
		if( $user->usuario_existe($email) ){
			echo $user->mostrar_alerta("warning", "el correo ya esta registrado");
			die();
		}else{
			//validar que el curp no exista en DB
			if( $user->usuario_curp_existe($curp) ){
				echo $user->mostrar_alerta("warning", "el curp ya esta registrado");
				die();
			}else{
				//registramos el usuario
				if( $user->registrar($name,$email,$hpassword,$curp) ){
					echo 'register';
					$_SESSION['user'] = $email;
				}else{
					echo $user->mostrar_alerta("danger", "no se pudo registrar intente mas tarde!!");
					die();
				}

			}

		}
	}

	//Iniciar Session del usuario al sistema
	if( isset($_POST['action']) && $_POST['action'] === 'login' ){
		$email = $user->limpiar_input($_POST['email']);
		$password = $user->limpiar_input($_POST['password']);
		//validemos que los datos no esten vacios
		if( $email === '' ){
			echo $user->mostrar_alerta("warning", "el usuario es un campo requerido");
			die();
		}
		//validamos que el pass no este vacio
		if( $password === '' ){
			echo $user->mostrar_alerta("warning", "el campo nombre es requerido");
			die();
		}
		//usamos la funcion de auth para revisar la base de datos
		$loggedInUser = $user->login($email);
		if( $loggedInUser != null ){
			if( password_verify($password, $loggedInUser['password']) ){
				echo 'login';
				$_SESSION['user'] = $email;
			}else{
				echo $user->mostrar_alerta("danger", "Datos incorrectos");
				die();				
			}
		}else{
			echo $user->mostrar_alerta("danger", "Error al iniciar session");
			die();
		}
	}


?>