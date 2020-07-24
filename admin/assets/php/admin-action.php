<?php

	require_once "admin-db.php";

	$admin = new Admin();
	session_start();

	//////////////////funciones del admin index.php
	//validacion para iniciar sesion
	if( isset($_POST['action']) && $_POST['action'] == 'adminLogin' ){
		$username = $admin->limpiar_input($_POST['username']);
		$password = $admin->limpiar_input($_POST['password']);
		//validamos que el usuario y la contraseña tengan valor y no esten vacios
		if( $username == '' ){
			echo $admin->mostrar_alerta('warning','El nombre de usuario es requerido!!!');
			die();
		}
		if( $password == '' ){
			echo $admin->mostrar_alerta('warning','La contraseña es un campo requerido!!!!');
			die();
		}
		//validamos los requerimientos del usuario y contraseña
		if( $admin->verificar_datos('[a-zA-Z0-9]{1,35}',$username) ){
			echo $admin->mostrar_alerta('danger','El usuario no tiene los requerimientos necesarios!!!!!!');
			die();
		}
		if( $admin->verificar_datos('[a-zA-Z0-9$@.-]{7,100}',$password) ){
			echo $admin->mostrar_alerta('danger', 'La contraseña no tiene los requerimientos necesarios!!!!!!');
			die();
		}

		$hpassword = sha1($password);
		$loggedInAdmin = $admin->admin_login($username,$hpassword);
		if($loggedInAdmin != null){
			echo "admin_login";
			$_SESSION['username'] = $username;
		}else{
			echo $admin->mostrar_alerta('danger','Usuario y/o Contraseña incorrectos');
			exit();
		}
	}



	///Funciones para admin-users.phpp
	//funcion para traer todos los usuarios
	if( isset($_POST['action']) && $_POST['action'] == 'traertodos' ){
		$salida = '';
		$datos = $admin->allUser(0);
		$path = '../assets/php/';
		if($datos){
			$salida = '<table class="table table-striped table-bordered text-center">
				<thead>
					<tr>
						<th>#</th>
						<th>imagen</th>
						<th>Nombre</th>
						<th>E-mail</th>
						<th>Genero</th>
						<th>Verificado</th>
						<th>Accion</th>
					</tr>
				</thead>
				<tbody>';
				foreach($datos as $row){
					if( $row['photo'] !='' ){	$uphoto = $path.$row['photo'];	}else{	$uphoto = '../assets/img/MaleAvatar.png';	}
					if( $row['verified'] ==0 ){	$verificado = "No verificado";	}else{	$verificado = "Verificado";	}
					$salida.='
						<tr>
							<td>'.$row['id'].'</td>
							<td><img src="'.$uphoto.'" class="rounder-circle" width="40px"></td>
							<td>'.$row['name'].'</td>
							<td>'.$row['email'].'</td>
							<td>'.$row['gender'].'</td>
							<td>'.$verificado.'</td>
							<td>
								<a href="#" id="'.$row['id'].'" title="View Details" class="text-primary userDetailsIcon" data-toggle="modal" data-target="#showUserDetailsModal">
									<i class="fas fa-info-circle fa-lg"></i>
								</a>
								<a href="#" id="'.$row['id'].'" title="Verificar Usuario" class="text-success userVerifiedIcon">
									<i class="fas fa-user-check fa-lg"></i>
								</a>
								<a href="#" id="'.$row['id'].'" title="Delete User" class="text-danger deleteUserIcon">
									<i class="fas fa-trash-alt fa-lg"></i>
								</a>
							</td>
						</tr>';
				}
				$salida.='</tbody></table>';
				echo $salida;
		}else{
			echo '<h3 class="text-center" text-secondary>Ooop no hay usuarios en el sistema!!</h3>';
		}
	}

	//Peticion para activar la cuenta de un usuario
	if( isset($_POST['activar_id']) ){
		$id = $admin->limpiar_input($_POST['activar_id']);
		$admin->activar_usuario($id, 1);
	}

	//Peticion para los detalles del usuario
	if ( isset($_POST['detail_id']) ){
		$id = $admin->limpiar_input($_POST['detail_id']);
		$data = $admin->dellates_usuario($id);
		echo json_encode($data);
	}

	//Peticion para eliminar el usuario
	if ( isset($_POST['delete_id']) ){
		$id = $admin->limpiar_input($_POST['delete_id']);
		$admin->borrar_usuario($id, 0);
	}

	///Funciones para admin-deleteuser.php
	//funcion para mostrar todos los usuarios eliminados
	if ( isset($_POST['action']) && $_POST['action'] === 'mostrareliminados' ){
		$salida = '';
		$datos = $admin->allUser(1);
		$path = '../assets/php/';
		if($datos){
			$salida = '<table class="table table-striped table-bordered text-center">
				<thead>
					<tr>
						<th>#</th>
						<th>imagen</th>
						<th>Nombre</th>
						<th>E-mail</th>
						<th>Genero</th>
						<th>Verificado</th>
						<th>Accion</th>
					</tr>
				</thead>
				<tbody>';
				foreach($datos as $row){
					if( $row['photo'] !='' ){	$uphoto = $path.$row['photo'];	}else{	$uphoto = '../assets/img/MaleAvatar.png';	}
					if( $row['verified'] ==0 ){	$verificado = "No verificado";	}else{	$verificado = "Verificado";	}
					$salida.='
						<tr>
							<td>'.$row['id'].'</td>
							<td><img src="'.$uphoto.'" class="rounder-circle" width="40px"></td>
							<td>'.$row['name'].'</td>
							<td>'.$row['email'].'</td>
							<td>'.$row['gender'].'</td>
							<td>'.$verificado.'</td>
							<td>
								<a href="#" id="'.$row['id'].'" title="Restore User" class="text-white restoreUserIcon badge badge-dark p-2">
									Restaurar
								</a>
							</td>
						</tr>';
				}
				$salida.='</tbody></table>';
				echo $salida;
		}else{
			echo '<h3 class="text-center" text-secondary>Ooop no hay usuarios eliminados en el sistema!!</h3>';
		}
	}

	//Funcion para reactivar el usuario
	if( isset($_POST['restore_id']) ){
		$id = $admin->limpiar_input($_POST['restore_id']);
		$admin->borrar_usuario($id, 1);
	}


	//////////////////////////////////////////////////////Funciones para admin-eventos
	//Agregar evento
	if( isset($_POST['action']) && $_POST['action'] === 'guardar_evento' ){
		$title = $admin->limpiar_input($_POST['title']);
		$costo = $admin->limpiar_input($_POST['costo']);
		$descripcion = $admin->limpiar_input($_POST['descripcion']);
		$inicioEvento = $admin->limpiar_input($_POST['inicioEvento']);
		$finEvento = $admin->limpiar_input($_POST['finEvento']);
		//Validacion de campos vacios
		if($title==""){
			echo $admin->mostrar_alerta('warning','titulo del evento es requerido!!!');
			die();
		}
		if($costo==''){
			echo $admin->mostrar_alerta('warning','El costo del evento es requerido!!!');
			die();
		}
		if($descripcion==''){
			echo $admin->mostrar_alerta('warning','La descripcion del evento es requerida!!!!');
			die();
		}
		if($inicioEvento==""){
			echo $admin->mostrar_alerta('warning','la fecha de inicio al evento es requerida!!!');
			die();
		}
		if( $finEvento=="" ){
			echo $admin->mostrar_alerta('warning','la ficha final del evento es requerida!!!!!');
			die();
		}
		//Validacion de tipo de caracteres
		if( $admin->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,90}',$title) ){
			echo $admin->mostrar_alerta('danger', 'el titulo del evento no cumple con el formato correcto!!');
			die();
		}
		if($admin->verificar_datos('(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))',$inicioEvento) ){
			echo $admin->mostrar_alerta('danger','la fecha de inicio del evento es incorrecta!!!!');
			die();
		}
		if($admin->verificar_datos('(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))',$finEvento)){
			echo $admin->mostrar_alerta('danger','la fecha final del evento es incorrecta!!!');
			die();
		}

		$admin->agregar_evento($title, $costo, $descripcion, $inicioEvento, $finEvento);
	}

	//Mostrar todos los eventos
	if( isset($_POST['action']) && $_POST['action'] === 'allevent' ){
		$salida = '';
		$datos = $admin->mostrarEventos(1);
		if($datos){
			$salida = '<table class="table table-striped table-bordered text-center">
				<thead>
					<tr>
						<th>#</th>
						<th>Nombre del Evento</th>
						<th>Costo</th>
						<th>Descripcion</th>
						<th>Fecha Inicio</th>
						<th>Fecha Final</th>
						<th>Estado</th>
						<th>Accion</th>
					</tr>
				</thead>
				<tbody>';
				foreach($datos as $row){
					$salida.='
						<tr>
							<td>'.$row['id'].'</td>
							<td>'.$row['nombreEvento'].'</td>
							<td>'.$row['costo'].'</td>
							<td>'.$row['descripcion'].'</td>
							<td>'.$row['finicio'].'</td>
							<td>'.$row['ffinal'].'</td>
							<td>'.$row['estado'].'</td>
							<td>
								<a href="#" id="'.$row['id'].'" title="View Details" class="text-primary eventDetailsIcon" data-toggle="modal" data-target="#editEventoModal">
									<i class="fas fa-info-circle fa-lg"></i>
								</a>
								<a href="#" id="'.$row['id'].'" title="Delete Evento" class="text-danger deleteEventIcon">
									<i class="fas fa-trash-alt fa-lg"></i>
								</a>
							</td>
						</tr>';
				}
				$salida.='</tbody></table>';
				echo $salida;
		}else{
			echo '<h3 class="text-center" text-secondary>Ooop no hay eventos en el sistema!!!!!!</h3>';
		}
	}

	//mostrar evento
	if( isset($_POST['editEvent_id']) ){
		$id = $admin->limpiar_input($_POST['editEvent_id']);
		$datos = $admin->editarEvento($id);
		echo json_encode($datos);
	}

	//Modificar evento
	if( isset($_POST['action']) && $_POST['action'] === 'edit_evento' ){
		$id = $admin->limpiar_input($_POST['edit_id']);
		$title = $admin->limpiar_input($_POST['title']);
		$costo = $admin->limpiar_input($_POST['costo']);
		$descripcion = $admin->limpiar_input($_POST['descripcion']);
		$inicioEvento = $admin->limpiar_input($_POST['inicioEvento']);
		$finEvento = $admin->limpiar_input($_POST['finEvento']);
		//Validar datos vacios
		if( $id == '' ){
			echo $admin->mostrar_alerta('danger','Error al Guardar el usuario');
			die();
		}
		if( $title == '' ){
			echo $admin->mostrar_alerta('danger','Error el titulo del evento es requerido!!!');
			die();
		}
		if( $costo == '' ){
			echo $admin->mostrar_alerta('danger','Error el costo es requerido!!!!!');
			die();
		}
		if( $descripcion == '' ){
			echo $admin->mostrar_alerta('danger','Error la descripcion es requerida!!!!!!');
			die();
		}
		if( $inicioEvento == '' ){
			echo $admin->mostrar_alerta('danger','Error la fecha de inicio es requerida!!!!!!!!');
			die();
		}
		if ( $finEvento == '' ){
			echo $admin->mostrar_alerta('danger','Error la fecha final del evento es requerida!!!!!!');
			die();
		}
		//Validacion de tipo de caracteres
		if( $admin->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,90}',$title) ){
			echo $admin->mostrar_alerta('danger', 'el titulo del evento no cumple con el formato correcto!!');
			die();
		}
		if($admin->verificar_datos('(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))',$inicioEvento) ){
			echo $admin->mostrar_alerta('danger','la fecha de inicio del evento es incorrecta!!!!');
			die();
		}
		if($admin->verificar_datos('(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))',$finEvento)){
			echo $admin->mostrar_alerta('danger','la fecha final del evento es incorrecta!!!');
			die();
		}
		//editamos el evento
		$admin->editarelEvento($title, $descripcion, $costo, $inicioEvento, $finEvento, $id);
	}

	//Eliminar Evento
	if ( isset($_POST['eventDelete_id']) ){
		$id = $admin->limpiar_input($_POST['eventDelete_id']);
		if( $id == '' ){
			echo $admin->mostrar_alerta('danger', 'Error para eliminar evento');
			die();
		}
		$admin->eliminarEvento($id, 0);
	}


	///////////////////////////////////////////////////////////////////////////////Funciones para Notificaciones.php
	//mostrar todas las notificaciones
	if( isset($_POST['action']) && $_POST['action'] === 'mostrarNotificaciones' ){
		$notificaciones = $admin->mostrarNotificaciones();
		$salida = '';
		if( $notificaciones ){
			foreach( $notificaciones as $row ){
				$salida.= '
					<div class="alert alert-dark" role="alert">
						<button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hiden="true">&times;</span>
						</button>
						<h4 class="alert-heading">Nueva Notificacion</h4>
						<p class="mb-0 lead">'.$row['mensaje'].' por '.$row['name'].'</p>
						<hr class="my-2">
						<p class="mb-0 float left"><b>email :</b>'.$row['email'].'</p>
						<p class="mb-0 float-right">'.$admin->tiempoAtras($row['created_at']).'</p>
						<div class="clearfix"></div>
					</div>';
			}
			echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary mt-5">No hay notificaciones que mostrar!!</h3>';
		}
	}

	//Eliminar las notificaciones
	if( isset($_POST['eliminarNotificacion_id']) ){
		$id = $admin->limpiar_input($_POST['eliminarNotificacion_id']);
		if($id == ''){
			echo $admin->mostrar_alerta('danger','Error no se puede eliminar la notificacion');
			die();
		}
		$admin->eliminarNotificacion($id, 0);
	}


	///////////////////////////////////////////////////////////////////////////////////Funciones para FEEDBACK.php

	//mostrar todos los feedbacks
	if( isset($_POST['action']) && $_POST['action'] === 'mostrarFeedbacks' ){
		$salida = '';
		$feedbacks = $admin->todoslosfeedbask();
		if( $feedbacks ){
			$salida .= '
				<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>ID</th>
							<th>titulo</th>
							<th>mensaje</th>
							<th>enviado</th>
							<th>Usuario</th>
							<th>Correo</th>
							<th>Responder</th>
						</tr>
					</thead>
				<tbody>';
				foreach($feedbacks as $row){
					$salida.='
						<tr>
							<td>'.$row['id'].'</td>
							<td>'.$row['titulo'].'</td>
							<td>'.$row['mensaje'].'</td>
							<td>'.$row['created_at'].'</td>
							<td>'.$row['name'].'</td>
							<td>'.$row['email'].'</td>
							<td>
								<a href="#" fid="'.$row['id'].'" id="'.$row['uid'].'" title="Responder" class="text-dark replyFeedbackIcon" data-toggle="modal" data-target="#showReplayModal"><i class="fas fa-reply fa-lg"></i></a>
							</td>
						</tr>';
				}
				$salida.='</tbody></table>';
				echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary">No hay mensajes aun!!!</h3>';
		}
	}

	//Responder el feedback
	if( isset($_POST['message']) ){
		$uid = $admin->limpiar_input($_POST['uid']);
		$message = $admin->limpiar_input($_POST['message']);
		$fid = $admin->limpiar_input($_POST['fid']);
		//Validamos si estan vacios
		if( $uid == '' ){
			echo $admin->mostrar_alerta('danger', 'Error para enviar el mensaje');
			die();
		}
		if( $message == '' ){
			echo $admin->mostrar_alerta('danger', 'El mensaje es necesario para enviar');
			die();
		}
		if( $fid == '' ){
			echo $admin->mostrar_alerta('danger', 'Fallo el envio intenta mas tarde');
			die();
		}

		//mandamos el mensaje
		$admin->replyFeedback($uid, $message);
		$admin->feedbackReply($fid);
		echo $admin->mostrar_alerta('success', 'Respuesta enviada!');


	}

?>