<?php
	require_once "assets/php/admin-header.php";
	require_once "assets/php/admin-db.php";
	$count = new Admin();
?>

<div class="row">
	<div class="col-lg-12">
		<div class="card-deck mt-3 text-light text-center font-weight-bold">
			<div class="card bg-dark">
				<div class="card-header">Total Users</div>
				<div class="card-body">
					<h3 class="display-4"><i class="fas fa-users"></i>&nbsp;&nbsp;<?= $count->totalCount('users'); ?></h3>
				</div>
			</div>
			
			<div class="card bg-dark">
				<div class="card-header">Usuarios Verificados</div>
				<div class="card-body"><h3 class="display-4"><i class="fas fa-user-check"></i>&nbsp;&nbsp;<?= $count->verificadosono(1); ?> </h3></div>
			</div>
			
			<div class="card bg-dark">
				<div class="card-header">Usuarios sin Verificar</div>
				<div class="card-body"><h1 class="display-4"><i class="fas fa-user-lock"></i>&nbsp;&nbsp;<?= $count->verificadosono(0); ?> </h1></div>
			</div>

		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card-deck mt-3 text-light text-center font-weight-bold">
			<div class="card bg-dark">
				<div class="card-header">Total de Feedbacks sin leer</div>
				<div class="card-body">
					<h1 class="display-4">
						<i class="fas fa-comment-alt fa-lg"></i><br>
						<?= $count->totalFeedbacks(); ?>
					</h1>
				</div>
			</div>
			
			<div class="card bg-dark">
				<div class="card-header">Total de notificaciones</div>
				<div class="card-body">
					<h1 class="display-4">
						<i class="fas fa-bell"></i><br>
						<?= $count->totalNotificacionesAdmin(1); ?>
					</h1>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="row">
	<div class="col-lg-12">
		<div class="card-deck my-3">
			<div class="card border-dark">
				<div class="card-header bg-dark text-center text-light lead">Porcentaje de Hombres y mujeres</div>
				<div id="hymporcentaje" style="width: 99%; height: 350px;"></div>
			</div>
			<div class="card border-dark">
				<div class="card-header bg-dark text-center text-light lead">Porcentaje de cuentas verificadas</div>
				<div id="verificadasporcentaje" style="width: 99%; height: 350px;"></div>
			</div>
		</div>
	</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<script type="text/javascript">

      	// Load the Visualization API and the corechart package.
      	google.charts.load('current', {'packages':['corechart']});

      	// Set a callback to run when the Google Visualization API is loaded.
      	google.charts.setOnLoadCallback(drawChart);

	    // Callback that creates and populates a data table,
	    // instantiates the pie chart, passes in the data and
	    // draws it.
	    function drawChart() {
	    	// Create the data table.
	        var data = new google.visualization.arrayToDataTable([
	        	['Gender','Number'],
	        	<?php
	        		$gender = $count->generoPorcentaje();
	        		foreach( $gender as $row ){
	        			if( $row['gender'] == 'Male' ){ $genero='Hombres'; }else{ $genero='Mujers'; }
	        			echo '["'.$genero.'",'.$row['number'].'],';
	        		}
	        	?>
	        	]);
	        // Set chart options
	        var options = {is3D : false};
	        // Instantiate and draw our chart, passing in some options.
	        var chart = new google.visualization.PieChart(document.getElementById('hymporcentaje'));
	        chart.draw(data, options);
	    }

	    /////////////////////////////////////segunda grafica del sistema
      	// Load the Visualization API and the corechart package.
      	google.charts.load('current', {'packages':['corechart']});

      	// Set a callback to run when the Google Visualization API is loaded.
      	google.charts.setOnLoadCallback(drawChart2);

	    // Callback that creates and populates a data table,
	    // instantiates the pie chart, passes in the data and
	    // draws it.
	    function drawChart2() {
	    	// Create the data table.
	        var data = new google.visualization.arrayToDataTable([
	        	['verified','Number'],
	        	<?php
	        		$verified = $count->verificadoPorcentaje();
	        		foreach( $verified as $row ){
	        			if($row['verified']==0){
	        				$row['verified'] = 'No verificado';
	        			}else{
	        				$row['verified'] = 'Verificado';
	        			}
	        			echo '["'.$row['verified'].'",'.$row['number'].'],';
	        		}
	        	?>
	        	]);
	        // Set chart options
	        var options = {is3D : false};
	        // Instantiate and draw our chart, passing in some options.
	        var chart = new google.visualization.PieChart(document.getElementById('verificadasporcentaje'));
	        chart.draw(data, options);
	    }


</script>