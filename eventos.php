<?php
	include_once "assets/php/header.php";
	date_default_timezone_set('America/Mexico_City');
	setlocale(LC_TIME, "spanish");
?>


<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div id="AlertaError" class="mt-2"></div>
			<?php if ($verified === 'No verificado'): ?>
				<div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
					<button class="close" type="button" data-dismiss="alert">&times;</button>
					<strong>
						Tu Email aun no esta verificado, para ver los eventos necesitan verificar tu cuenta.
					</strong>
				</div>
			<?php else:	?>
				<div class="card my-2 border-dark">
					<div class="card-header bg-dark text-white">
						<h4 class="m-0 text-center">Eventos para el mes <?php echo strftime("%B"); ?></h4>
					</div>
					<div class="card-body">
						<div class="table-responsive" id="showAllEvent">
							<p class="text-center align-self-center lead">Cargando eventos.........</p>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>



<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.21/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

<script type="text/javascript">
	$(document).ready(function(){

		Eventospormes();

		//mostrar los eventos del mes
		function Eventospormes(){
			$.ajax({
				url : 'assets/php/process.php',
				method : 'post',
				data : { action : 'eventosxmes' },
				success:function(response){
					$('#showAllEvent').html(response);
				}
			});
		}

		//Registrarse en el evento
		$('body').on('click','.eventDetailsIcon',function(e){
			e.preventDefault();
			EventoInscripcion_id = $(this).attr('id');
			Swal.fire({
				title : '¿Deseas Inscribirte en el Evento?',
				text : 'Estas seguro que deseas estar inscrito en el evento!!!',
				type : 'info',
				showCancelButton : true,
				confirmButtonColor : '#3085d6',
				cancelButtonColor : '#d33',
				confirmButtonText : 'Si Inscribirse en el evento',
			}).then((result)=>{
				if( result.value ){
					$.ajax({
						url: 'assets/php/process.php',
						method : 'post',
						data : { EventoInscripcion_id: EventoInscripcion_id },
						success:function(response){
							$('#AlertaError').html(response);
						}
					});
				}
			});
		});


	});
</script>