<?php
	require_once "assets/php/admin-header.php";
	require_once "assets/php/admin-db.php";
	$count = new Admin();
?>

	<div class="row justify-content-center my-2">
		<div id="AlertaNotificacion" class="mt-3"></div>
		<div class="col-lg-8 mt-4" id="showNotification"></div>
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

<script type="text/javascript">
	$(document).ready(function(){

		mostrarTodasNotificaciones();

		//mostrar todas las notificaciones
		function mostrarTodasNotificaciones(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { action : 'mostrarNotificaciones' },
				success:function(response){
					$('#showNotification').html(response);
				}
			});
		}

		//Eliminar las notificaciones
		$('body').on('click','.close',function(e){
			e.preventDefault();
			eliminarNotificacion_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { eliminarNotificacion_id : eliminarNotificacion_id },
				success : function(response){
					mostrarTodasNotificaciones();
				}
			});
		});

	});
</script>