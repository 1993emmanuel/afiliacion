<?php
	require_once 'config.php';

	class Admin extends Database{

		//funcion para iniciar sesion administrador
		public function admin_login( $username, $password ){
			$sql = "SELECT username, password FROM admin WHERE username = :username AND password = :password ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['username'=>$username, 'password'=>$password ]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}

		////////////////////////////////funcion para admin-user.php
		//Funcion para traer todos los usuarios
		public function allUser($val){
			$sql = "SELECT * FROM users WHERE deleted!= $val";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Funcion para Activar el usuario
		public function activar_usuario($id, $val){
			$sql = "UPDATE users SET verified = $val WHERE id=:id ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}

		//Funcion para traer los detalles del usuario
		public function dellates_usuario($id){
			$sql = "SELECT * FROM users WHERE id=:id AND deleted!=0";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Funcion para borrar el usuario de la base de datos
		public function borrar_usuario($id, $val){
			$sql = "UPDATE users SET deleted=$val WHERE id=:id";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}

		//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		//////Funciones para admin-event

		//Agregar evento a la base de datos
		public function agregar_evento($nombreEvento, $costo, $descripcion, $finicio, $ffinal){
			$sql = "INSERT INTO eventos(nombreEvento,costo,descripcion,finicio,ffinal) VALUES(:nombreEvento,:costo,:descripcion,:finicio,:ffinal)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['nombreEvento'=>$nombreEvento,'costo'=>$costo,'descripcion'=>$descripcion,'finicio'=>$finicio,'ffinal'=>$ffinal]);
			return true;
		}

		//Mostrar todos los eventos de la base de datos
		public function mostrarEventos($val){
			$sql = "SELECT * FROM eventos WHERE estado=$val";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//mostrar evento
		public function editarEvento($id){
			$sql = "SELECT * FROM eventos WHERE id=:id AND estado = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Editar Evento
		public function editarelEvento($title, $descripcion, $costo, $inicioEvento, $finEvento, $id){
			$sql = "UPDATE eventos SET nombreEvento =:nombreEvento, costo = :costo, descripcion=:descripcion, finicio=:finicio, ffinal=:ffinal WHERE id=:id AND estado = 1 ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['nombreEvento'=>$title, 'costo'=>$costo, 'descripcion'=>$descripcion, 'finicio'=>$inicioEvento, 'ffinal'=>$finEvento, 'id'=>$id]);
			return true;
		}

		//Eliminar Evento
		public function eliminarEvento($id, $val){
			$sql = "UPDATE eventos SET estado=$val WHERE id=:id";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}

		///////////////////////////////////////////////////////////////////////////////////FUNCIONES PARA NOTIFICACIONES.php
		//mostrar todas las notificaciones
		public function mostrarNotificaciones(){
			$sql = "SELECT notificaciones.id, notificaciones.mensaje, notificaciones.created_at, users.name, users.email 
					FROM notificaciones INNER JOIN users ON notificaciones.uid = users.id WHERE tipo = 'admin' AND estado = 1 ORDER BY notificaciones.id DESC LIMIT 5";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Eliminar la notificacion
		public function eliminarNotificacion($id, $val){
			$sql = "UPDATE notificaciones SET estado=$val WHERE id = :id";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}

		///////////////////////////////////////////////////////////////////////////////////FUNCIONES PARA FEEDBACK.php

		//mostrar todas los feedbacks
		public function todoslosfeedbask(){
			$sql = "SELECT feedback.id, feedback.titulo, feedback.mensaje, feedback.created_at, feedback.uid, users.name, users.email 
					FROM feedback INNER JOIN users ON feedback.uid = users.id WHERE replied != 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Reenviar para el usuario
		public function replyFeedback($uid, $message){
			$sql = "INSERT INTO notificaciones(uid, tipo, mensaje)VALUES(:uid,'user',:mensaje)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['uid'=>$uid, 'mensaje'=>$message]);
			return true;
		}

		//Cambiar el estado a reply
		public function feedbackReply($fid){
			$sql = "UPDATE feedback SET replied=1 WHERE id=:fid AND estatus = 1";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['fid'=>$fid]);
			return true;
		}

		//////////////////////////////////////////////////////////////////////////////FUNCIONES PARA DASHBOARD

		//Conteo de cualquier tabla
		public function totalCount($tablename){
			$sql = "SELECT * FROM $tablename";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$contar = $stmt->rowCount();
			return $contar;
		}

		//usuarios verificados y no verificados
		public function verificadosono($status){
			$sql = "SELECT * FROM users WHERE verified = :status";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['status'=>$status]);
			$contar = $stmt->rowCount();
			return $contar;
		}

		//total de feedbacks sin responder
		public function totalFeedbacks(){
			$sql = "SELECT * FROM feedback WHERE estatus=1 AND replied =0";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->rowCount();
			return $resultado;
		}

		//total de notificaciones para el admin
		public function totalNotificacionesAdmin($val){
			$sql = "SELECT * FROM notificaciones WHERE estado = $val AND tipo = 'admin'";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->rowCount();
			return $resultado;
		}

		//Genero
		public function generoPorcentaje(){
			$sql = "SELECT gender, COUNT(*) as number FROM users WHERE gender!='' GROUP BY gender";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//PorcentajeVerificado
		public function verificadoPorcentaje(){
			$sql = "SELECT verified, COUNT(*) as number FROM users GROUP BY verified";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute();
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}


	}
?>