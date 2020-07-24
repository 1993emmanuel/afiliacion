<?php
	require_once "assets/php/admin-header.php";
	require_once "assets/php/admin-db.php";
	$count = new Admin();
?>

	<div class="row">
		<div class="col-lg-12">
			<div class="card my-2 border-dark">
				<div class="card-header bg-dark text-white"><h4 class="m-0">Total de usuarios Eliminados</h4></div>
				<div class="card-body">
					<div class="table-responsive" id="showAllDeleteUser">
						<p class="text-center align-self-center lead">Espere por favor.............</p>
					</div>
				</div>
			</div>
		</div>
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

		mostrarUsuariosEliminados();

		//Funcion para mostrar todos los usuarios eliminados
		function mostrarUsuariosEliminados(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { action : 'mostrareliminados' },
				success: function(response){
					$('#showAllDeleteUser').html(response);
					$('table').DataTable({
						order : [0,'desc']
					});
				}
			});
		}

		//Funcion para activar de nuevo el usuario en el sistema
		$('body').on('click','.restoreUserIcon',function(e){
			e.preventDefault();
			restore_id = $(this).attr('id');
			Swal.fire({
				title : '¿Quiere restaurar el usuario?',
				type : 'warning',
				showCancelButton : true,
				confirmButtonColor : '#3085d6',
				cancelButtonColor : '#d33',
				confirmButtonText : 'Si, restaurar el usuario',
			}).then((result)=>{
				if(result.value){
					$.ajax({
						url : 'assets/php/admin-action.php',
						method : 'post',
						data : { restore_id, restore_id },
						success: function(response){
							Swal.fire(
								'Restaurado!!!',
								'El usuario fue restaurado correctamente!!!',
								'success'
							)
							mostrarUsuariosEliminados();
						}
					});
				}
			});
		});

	});
</script>