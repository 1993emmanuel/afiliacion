<?php

	/*
		El archivo auth se encargara de las funciones basicas como realizar
		consultas para la base de datos ya sean 
		create read update delete
		y es la unica finalidad de este archivo.
	*/

	require_once 'config.php';
		
	class Auth extends Database{

		//Registrar un usuario desde el formulario en la base de datos
		public function registrar( $name, $email, $password, $curp ){
			$sql = "INSERT INTO users(name, email, password, curp) VALUES(:name, :email, :password, :curp)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['name'=>$name, 'email'=>$email, 'password'=>$password, 'curp'=>$curp ]);
			return true;
		}

		//Verificar si el correo del usuario ya esta registrado
		public function usuario_existe($email){
			$sql = "SELECT email FROM users WHERE email = :email";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['email'=>$email]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		}

		//Verificar si el CURP del usuario ya esta registrado
		public function usuario_curp_existe($curp){
			$sql = "SELECT curp FROM users WHERE curp = :curp";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['curp'=>$curp]);
			$result = $stmt->fetch(PDO::FETCH_ASSOC);
			return $result;
		}

		//function para iniciar sesion en el sistema
		public function login($email){
			$sql = "SELECT email, password FROM users WHERE email=:email AND deleted != 0 ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['email'=>$email ]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}

		//query para obtener los datos para las variables de session
		public function currentUser($email){
			$sql = "SELECT * FROM users WHERE email=:email AND deleted !=0 ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['email'=>$email]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			return $row;
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		///funciones para profile.php
		////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
		public function cambiar_contrasena($pass,$id){
			$sql = "UPDATE users SET password = :pass WHERE id =:id AND deleted!=0";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['pass'=>$pass,'id'=>$id]);
			return true;
		}

		//Actualizar el perfil del ususario
		public function actualizar_perfil($name, $gender, $dob, $phone, $photo, $id){
			$sql="UPDATE users SET name=:name, gender=:gender, dob=:dob, phone=:phone, photo=:photo WHERE id=:id AND deleted!=0";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([ 'name'=>$name, 'gender'=>$gender, 'dob'=>$dob, 'phone'=>$phone, 'photo'=>$photo, 'id'=>$id ]);
			return true;
		}

		//Funcion para guardar la ruta de los archivos
		public function actualizar_archivos($acta, $comprobante, $id){
			$sql = "UPDATE users SET acta=:acta, comprobante=:comprobante WHERE id=:id AND deleted!=0 ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['acta'=>$acta, 'comprobante'=>$comprobante,'id'=>$id]);
			return true;
		}

		//Funcion para cambiar los datos complementarios del usuario CURP Y FatherPhone
		public function actualizar_complementarios($father_phone, $curp, $id){
			$sql = "UPDATE users SET father_phone=:father_phone, curp=:curp WHERE id=:id AND deleted!=0 ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute([ 'father_phone'=>$father_phone, 'curp'=>$curp, 'id'=>$id ]);
			return true;
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////
		///Eventos.php

		//mostrar todos los eventos del mes
		public function mostrarEventosdelMes($inicio,$final){
			$sql = "SELECT * FROM eventos WHERE (finicio >=:finicio AND ffinal<=:ffinal) AND estado=1 ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['finicio'=>$inicio, 'ffinal'=>$final]);
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//function para registrarte en el evento
		public function registrarenEvento($idEvento, $idUsuario, $curp){
			$sql = "INSERT INTO inscripcionesevento(idevento, idusuario, curp) VALUES(:idevento, :idusuario, :curp)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['idevento'=>$idEvento, 'idusuario'=>$idUsuario, 'curp'=>$curp]);
			return true;
		}

		//validar si el usuario esta inscrito al evento
		public function inscritoEvento($id, $curp){
			$sql = "SELECT idusuario, curp FROM inscripcionesevento WHERE idusuario=:idusuario AND curp=:curp";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['idusuario'=>$id, 'curp'=>$curp]);
			$resultado = $stmt->fetch(PDO::FETCH_ASSOC);
			return $resultado;
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////
		///Notificaciones.php

		//Insertar Notificacion
		public function notificacion($uid, $tipo, $mensaje){
			$sql = "INSERT INTO notificaciones(uid,tipo,mensaje) VALUES(:uid,:tipo,:mensaje)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['uid'=>$uid, 'tipo'=>$tipo, 'mensaje'=>$mensaje]);
			return true;
		}

		//mostrar todas las notificaciones
		public function mostrarNotificaciones($uid ,$val){
			$sql = "SELECT * FROM notificaciones WHERE uid=:uid AND estado=$val AND tipo = 'user' ";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['uid'=>$uid]);
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $resultado;
		}

		//Eliminar la notificacion
		public function eliminarNotificacion($id){
			$sql = "UPDATE notificaciones SET estado=0 WHERE id=:id";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['id'=>$id]);
			return true;
		}

		////////////////////////////////////////////////////////////////////////////////////////////////////
		///FeedBack.php

		//Guardar el feedback
		public function guardarFeedback($uid, $titulo, $mensaje){
			$sql = "INSERT INTO feedback(uid, titulo, mensaje)VALUES(:uid,:titulo, :mensaje)";
			$stmt = $this->conn->prepare($sql);
			$stmt->execute(['uid'=>$uid, 'titulo'=>$titulo, 'mensaje'=>$mensaje]);
			return true;
		}

	}
?>