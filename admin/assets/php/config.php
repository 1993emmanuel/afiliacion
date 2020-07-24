<?php

	class Database{

		private $dsn = "mysql:host=localhost;dbname=db_afiliate_system";
		private $dbuser = "root";
		private $dbpass = "";

		public $conn;

		public function __construct(){
			try{
				$this->conn = new PDO($this->dsn, $this->dbuser, $this->dbpass);
			}catch(PDOException $e){
				echo "Errorr : ". $e->getMessage();
			}
			return $this->conn;
		}

		//Limpiar los inputs
		public function limpiar_input($data){
			$data = trim($data);
			$data = stripcslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		//Alerta para mostrar
		public function mostrar_alerta($type, $mensaje){
			return '
				<div class="alert alert-'.$type.' alert-dismissible">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong class="text-center">'.$mensaje.'</strong>
				</div>
			';
		}

		//Validar el valor html pattern la funcion recibe la cadena a verificar y el filtro
		public function verificar_datos($filtro, $cadena){
			if( preg_match("/^".$filtro."$/", $cadena) ) {
				return false;
			}else{
				return true;
			}
		}

		public function _data_first_month_day() { 
	      $month = date('m');
	      $year = date('Y');
	      return date('Y-m-d', mktime(0,0,0, $month, 1, $year));
	    }

	    public function _data_last_month_day() { 
	      $month = date('m');
	      $year = date('Y');
	      $day = date("d", mktime(0,0,0, $month+1, 0, $year));
	      return date('Y-m-d', mktime(0,0,0, $month, $day, $year));
	  	}

	  	//Funcion para el tiempo del usuario
		public function tiempoAtras($timestamp){
			date_default_timezone_set('America/Mexico_City');
			//this transform the timestamp in seconds
			$timestamp = strtotime($timestamp) ? strtotime($timestamp) : $timestamp;
			$time = time()- $timestamp;

			switch($time){
				//Seconds
				case $time <= 60:
					return 'Just Now!!';
				break;
				//minutes
				case $time >=60 && $time < 3600:
					return (round($time/60) == 1 ) ? 'un minuto atras' : round($time/60).' minutos atras';
				break;
				//hours
				case $time >= 3600 && $time < 86400:
					return (round($time/3600)==1) ? 'una hora atras' : round($time/3600).' horas atras';
				break;
				//days
				case $time >= 86400 && $time < 604800:
					return ( round($time/86400)==1 ) ? 'un dia atras' : round($time/86400).' dias atras';
				break;
				//week
				case $time >= 604800 && $time < 2600640:
					return ( round($time/604800) == 1 ) ? 'una semana atras' : round($time/604800).' semanas atras';
				break;
				//Month
				case $time >= 2600640 && $time <31207680:
					return ( round($time/2600640) == 1 ) ? 'un mes atras' : round($time/2600640).' meses atras';
				break;
				//Year
				case $time >= 31207680:
					return ( round($time/31207680) == 1 ) ? 'un año atras' : round($time/31207680).' años atras';
				break;
			}
			
		}




	}
?>