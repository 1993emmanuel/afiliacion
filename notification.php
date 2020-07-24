<?php
	include_once "assets/php/header.php";
?>


<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<?php if ($verified === 'No verificado'): ?>
				<div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
					<button class="close" type="button" data-dismiss="alert">&times;</button>
					<strong>
						Tu Email aun no esta verificado, Necesitas subir tu informacion en perfil y esperar que un administrador valide tu informacion.
					</strong>
				</div>
			<?php else:	?>
				<div id="showAllNotification" class="mt-2 m-0"></div>
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

		mostrarTodasNotificaciones();

		//Funcion para traer todas las notificaciones
		function mostrarTodasNotificaciones(){
			$.ajax({
				url : 'assets/php/process.php',
				method: 'post',
				data : {action : 'mostrarTodasNotificaciones'},
				success:function(response){
					$('#showAllNotification').html(response);
				}
			});
		}

		//remover la notificacion
		$('body').on('click','.close',function(e){
			e.preventDefault();
			notificaciones_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/process.php',
				method : 'post',
				data : { notificaciones_id : notificaciones_id },
				success: function(response){
					mostrarTodasNotificaciones();
				}
			});
		});

	});
</script>