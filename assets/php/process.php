<?php

	require_once "session.php";

	/*
		Este archivo se encargara del proceso de los archivos del usuario
		y incluye nuestro archivo session.php el cual ya tiene los datos
		de auth
	*/

	////////////////////////////////////////////////////////////////////////////////////////
	//Funciones de la pagina profile.php
	//funcion para cambiar contraseñas
	if( isset($_POST['action']) && $_POST['action'] === 'change_pass' ){
		$currentPass = $cuser->limpiar_input($_POST['curpass']);
		$newPass = $cuser->limpiar_input($_POST['newpass']);
		$cnewpass = $cuser->limpiar_input($_POST['cnewpass']);
		//Validar si los datos estas vacios
		if( $currentPass === '' ){
			echo $cuser->mostrar_alerta("warning", "la contraseña actual es requerida!!!");
			die();
		}
		if( $newPass === '' ){
			echo $cuser->mostrar_alerta("warning", "nueva contraseña requerida!!!");
			die();
		}
		if( $cnewpass === '' ){
			echo $cuser->mostrar_alerta("warning", "repetir la contraseña  requerida!!!");
			die();
		}

		//validar requerimientos de las contrasenas
		if( $cuser->verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$currentPass) ){
			echo $cuser->mostrar_alerta("warning", "la contraseña no cumple los requerimientos!!!!");
			die();
		}
		if( $cuser->verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$newPass) ){
			echo $cuser->mostrar_alerta("warning", "la contraseña nueva no cumple los requerimientos!!!!");
			die();
		}
		if( $cuser->verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$cnewpass) ){
			echo $cuser->mostrar_alerta("warning", "la contraseña nueva2 no cumple los requerimientos!!!!");
			die();
		}

		//Validamos contraseñas
		$hnewPass = password_hash($newPass, PASSWORD_DEFAULT);
		if( $newPass != $cnewpass ){
			echo $cuser->mostrar_alerta('danger','Password did not matched!!');
		}else{
			//esta funcion revisa que el password actual sea igual con el que tenemos en sesion despues del hash
			if( password_verify($currentPass, $cpass) ){
				$cuser->cambiar_contrasena($hnewPass,$cid);
				echo $cuser->mostrar_alerta('success','Password Changed Successfully!!');
				$cuser->notificacion($cid, 'admin', 'contraseña cambiada correctamente');
			}else{
				echo $cuser->mostrar_alerta('danger','Current Password is Wrong!!');
			}
		}
	}

	//Funcion para cambiar la foto del usuario y cambiar los datos del mismo
	if( isset($_FILES['image']) ){
		$name = $cuser->limpiar_input($_POST['name']);
		$gender = $cuser->limpiar_input($_POST['gender']);
		$dob = $cuser->limpiar_input($_POST['dob']);
		$phone = $cuser->limpiar_input($_POST['phone']);

		//variables de las imagenes
		$oldImage = $_POST['oldimage'];
		$folder = 'uploads/';

		//validacion del nombre
		if($cuser->verificar_datos('[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}',$name)){
			$cuser->mostrar_alerta("danger",'Error en los requisitos del nombre');
			die();
		}

		if($cuser->verificar_datos('[0-9()+]{8,20}',$phone)){
			$cuser->mostrar_alerta("danger",'Error en los requisitos del telefono');
			die();
		}

		//si llegamos a recibir una imagen hay que moverla al folder
		if( isset($_FILES['image']['name']) && $_FILES['image']['name'] != "" ){
			$newImage = $folder.$_FILES['image']['name'];
			move_uploaded_file($_FILES['image']['tmp_name'], $newImage);
			if( $oldImage != null ){
				unlink($oldImage);
			}
		}else{
			$newImage = $oldImage;
		}
		$cuser->actualizar_perfil($name, $gender, $dob, $phone, $newImage, $cid);
		$cuser->notificacion($cid, 'admin', 'Foto y datos del usuario cambiados');
	}

	//funcion para guardar los dos archivos del usuario
	if ( isset($_FILES['acta']) && isset($_FILES['pago']) ){
		$oldActa = $_POST['oldfileacta'];
		$oldPago = $_POST['oldfilepago'];

		$carpeta = 'files/';
		if( isset($_FILES['acta']['name']) && $_FILES['acta']['name'] != "" ){
			$newArchivo = $carpeta.$_FILES['acta']['name'];
			$newArchivo2 = $carpeta.$_FILES['pago']['name'];
			move_uploaded_file($_FILES['acta']['tmp_name'], $newArchivo);
			move_uploaded_file($_FILES['pago']['tmp_name'], $newArchivo2);
			if( $oldActa != null ){
				unlink($oldActa);
			}
			if( $oldPago != null){
				unlink($oldPago);
			}
		}else{
			$newArchivo = $oldActa;
			$newArchivo2 = $oldPago;
		}
		$cuser->actualizar_archivos($newArchivo, $newArchivo2, $cid);
		$cuser->notificacion($cid, 'admin', 'Archivos del usuario subidos');
	}

	//Function para cambiar los datos complementarios del usuario
	if ( isset($_POST['action']) && $_POST['action'] === 'change_complementarios' ){
		$phoneFather = $cuser->limpiar_input($_POST['phoneFather']);
		$curp = $cuser->limpiar_input($_POST['curp']);
		//Validamos que tienen valores dentro
		if( $phoneFather == "" ){
			echo $cuser->mostrar_alerta('danger','el numero del padre es requerido!');
			die();
		}
		if( $curp=='' ){
			echo $cuser->mostrar_alerta('danger','el curp es un campo requerido!');
			die();
		}
		//Validaremos los filtros del telefono y curp
		if( $cuser->verificar_datos("[0-9()+]{8,20}", $phoneFather) ){
			echo $cuser->mostrar_alerta('danger','Error en el telefono del padre');
			die();
		}
		if( $cuser->verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,16}",$curp) ){
			echo $cuser->mostrar_alerta('danger','Error en el curp del deportista');
			die();
		}
		$cuser->actualizar_complementarios($phoneFather, $curp, $cid);
		$cuser->notificacion($cid, 'admin', 'datos complementarios cambiados');
	}


	//////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////EVENTOS.PHP

	//mostrar todos los eventos mesxmes
	if( isset($_POST['action']) && $_POST['action'] == 'eventosxmes' ){
		$output = '';
		$inicio = $cuser->_data_first_month_day();
		$final = $cuser->_data_last_month_day();
		$data = $cuser->mostrarEventosdelMes($inicio,$final);
		if($data){
			$output .= '<table class="table table-striped table-bordered text-center">
					<thead>
						<tr>
							<th>#</th>
							<th>nombre Evento</th>
							<th>Costo</th>
							<th>Descripcion</th>
							<th>Fecha de Inicio</th>
							<th>Fecha Final</th>
							<th>Estatus</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>';
					foreach( $data as $row ){
						if( $row['estado'] == 1 ){ $estado = "Activo"; } else { $estado = "Inactivo"; }
						$output.='
							<tr>
								<td>'.$row['id'].'</td>
								<td>'.$row['nombreEvento'].'</td>
								<td>'.$row['costo'].'</td>
								<td>'.$row['descripcion'].'</td>
								<td>'.$row['finicio'].'</td>
								<td>'.$row['ffinal'].'</td>
								<td>'.$estado.'</td>
								<td>
									<a href="#" id="'.$row['id'].'" title="Inscibirse" class="text-primary eventDetailsIcon">
										<i class="fas fa-sign-in-alt fa-lg"></i>&nbsp;&nbsp;
									</a>
								</td>
							</tr>';
					}
					$output.='</tbody></table>';
					echo $output;
		}else{
			echo '<h3 class="text-center text-secondary">:( no hay eventos para este mes </h3>';
		}
	}

	//Inscribirse al evento
	if( isset($_POST['EventoInscripcion_id']) ){
		$idEvento = $cuser->limpiar_input($_POST['EventoInscripcion_id']);
		if( $idEvento== "" ){
			echo $cuser->mostrar_alerta('danger','Error al registrarse!!!!!!');
			die();
		}
		if( $cid == "" ){
			echo $cuser->mostrar_alerta('danger','Error al registrar al usuario !!!!');
			die();
		}
		if( $ccurp == "" ){
			echo $cuser->mostrar_alerta('danger', 'Error al registrar al usuario en el evento!!!!!');
			die();
		}
		//Validar si es que esta registrado el usuario
		if( $cuser->inscritoEvento($cid, $ccurp) ){
			echo $cuser->mostrar_alerta('warning','Ooops ya estas inscrito a este evento!!!!!');
			die();
		}else{
			$cuser->registrarenEvento($idEvento, $cid, $ccurp);
			echo $cuser->mostrar_alerta('success','Felicidades estas inscrito al evento!!!!!');
			$cuser->notificacion($cid, 'admin', 'usuaio inscrito al evento');
			die();
		}
	}


	//////////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////////NOTIFICACIONES.PHP

	//mostrar todas las notifiaciones
	if( isset($_POST['action']) && $_POST['action'] === 'mostrarTodasNotificaciones' ){
		$notificaciones = $cuser->mostrarNotificaciones($cid, 1);
		$salida = '';
		if( $notificaciones ){
			foreach( $notificaciones as $row ){
				$salida.='
					<div class="alert alert-danger" role="alert">
						<button type="button" id="'.$row['id'].'" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
						<h4 class="alert-heading">New Notification</h4>
						<p class="mb-0 lead">'.$row['mensaje'].'</p>
						<hr class="my-2">
						<p class="mb-0 float-left">Reply of feedback from Admin</p>
						<p class="mb-0 float-right">'.$cuser->tiempoAtras($row['created_at']).'</p>
						<div class="clearfix"></div>
					</div>';
			}
			echo $salida;
		}else{
			echo '<h3 class="text-center text-secondary mt-5">No hay notificaciones que mostrar!!</h3>';
		}
	}

	//Eliminar las notificaciones
	if( isset($_POST['notificaciones_id']) ){
		$id = $cuser->limpiar_input($_POST['notificaciones_id']);
		if ( $id =='' ){
			echo $cuser->mostrar_alerta('danger', 'Error al eliminar la notificacion');
			die();
		}
		$cuser->eliminarNotificacion($id);
	}

	////////////////////////////////////////////////////////////////////////////////////////////////////
	////////////////////////////////////////////FEEDBAACK.php

	//Enviar feedback
	if( isset($_POST['action']) && $_POST['action'] === 'feedback' ){
		$subject = $cuser->limpiar_input($_POST['subject']);
		$feedback = $cuser->limpiar_input($_POST['feedback']);
		//validar si estan vacias
		if( $subject== '' ){
			echo $cuser->mostrar_alerta('warning', 'el titulo del mensaje es requerido!!!');
			die();
		}
		if( $feedback == '' ){
			echo $cuser->mostrar_alerta('warning', 'el contenido del mensaje es requerido!!!!');
			die();
		}
		$cuser->guardarFeedback($cid, $subject, $feedback);
		$cuser->notificacion($cid, 'admin', 'se envio el feedback');
		echo $cuser->mostrar_alerta('success','El mensaje fue enviado correctamente');

	}

?>