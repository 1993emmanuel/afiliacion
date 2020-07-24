<?php
	require_once "assets/php/admin-header.php";
	require_once "assets/php/admin-db.php";
	$count = new Admin();
?>

	<div class="row">
		<div class="col-lg-12">
			<div class="card my-2 border-dark">
				<div class="card-header bg-dark text-white"><h4 class="m-0">Total de usuarios Registrados</h4></div>
				<div class="card-body">
					<div class="table-responsive" id="showAllUser">
						<p class="text-center align-self-center lead">Espere por favor.............</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="showUserDetailsModal">
		<div class="modal-dialog modal-dialog-centered mw-100 w-50">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title" id="getName"></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<div class="card-deck">
						<div class="card border-dark">
							<p id="getEmail"></p>
							<p id="getphone"></p>
							<p id="getfatherphone"></p>
							<p id="getgender"></p>
							<p id="getdob"></p>
							<p id="getcurp"></p>
							<p id="getverified"></p>
							<p id="getCreated"></p>
							<h5 class="text-center">|Archivos|</h5>
							<div class="container">
								<div class="row align-self-center">
									<div class="col-lg-4" id="actadiv">
										<a href="#"><i class="fas fa-file fa-lg"></i>&nbsp;Acta</a>
									</div>
									<div class="col-lg-8" id="comprobantediv">
										<a href="#"><i class="fas fa-file fa-lg"></i>&nbsp;Comprobante</a>
									</div>
								</div>
							</div>
							<br>
						</div>
						<div class="card align-self-center" id="getimagen"></div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
		//Traer todos los usaurios
		traertodoslosusuarios();

		function traertodoslosusuarios(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {action : 'traertodos'},
				success:function(response){
					$('#showAllUser').html(response);
					$('table').DataTable({
						order : [0,'desc']
					});
				}
			});
		}

		// Detalles del usuario
		$('body').on('click','.userDetailsIcon',function(e){
			e.preventDefault();
			detail_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { detail_id , detail_id },
				success : function(response){
					data = JSON.parse(response);
					$('#getName').text(data.name+" "+'(ID:'+data.id+')');
					$('#getEmail').text('Email : '+data.email);
					$('#getphone').text('Telefono : '+data.phone);
					$('#getfatherphone').text('Telefono del Padre : '+data.father_phone);
					$('#getgender').text('Genero : '+data.gender);
					$('#getdob').text('Cumpleaños : '+data.dob);
					$('#getcurp').text('CURP : '+data.curp);
					if( data.acta != "" ){
						$('#actadiv').html('<a href="../assets/php/'+data.acta+'" target="_blank"><i class="fas fa-file fa-lg"></i>&nbsp;Acta</a>');
					}else{
						$('#actadiv').html('<p><strong>SIN ACTA</strong></p>');
					}
					if( data.comprobante != "" ){
						$('#comprobantediv').html('<a href="../assets/php/'+data.comprobante+'" target="_blank"><i class="fas fa-file fa-lg"></i>&nbsp;Comprobante</a>');
					}else{
						$('#comprobantediv').html('<p><strong>SIN COMPROBANTE</strong></p>');
					}

					if( data.verified == 1 ){$('#getverified').text('Estado : Verificado');}else{$('#getverified').text('Estado : Sin-Verificar');}

					$('#getCreated').text('Creado : '+data.created_at);
					if(data.photo != ''){
						$('#getimagen').html(' <img src="../assets/php/'+data.photo+'" class="img-thumbnail img-fluid align-self-center" width="280px">');
					}else{
						$('#getimagen').html(' <img src="../assets/img/avatar.png" class="img-thumbnail img-fluid align-self-center" width="280px">');
					}
				}
			});
		});

		//Activar la cuenta de un usuario
		$('body').on('click','.userVerifiedIcon',function(e){
			e.preventDefault();
			activar_id =  $(this).attr('id');
			//Alerta para activar un usuario
			Swal.fire({
				title: '¿Activar Cuenta?',
				text : 'Deseas Activar esta cuenta',
				type : 'warning',
				showCancelButton : true,
				confirmButtonColor : '#3085d6',
				cancelButtonColor : '#d33',
				confirmButtonText : 'Activar Cuenta',
			}).then((result)=>{
				if(result.value){
					//Peticion Ajax para activar la cuenta
					$.ajax({
						url : 'assets/php/admin-action.php',
						method : 'post',
						data : { activar_id, activar_id },
						success:function(response){
							Swal.fire(
									'Verificado',
									'Usuario verificado Correctamente',
									'success'
								)
							traertodoslosusuarios();
						}
					});
				}
			});
		});

		//Borrar un usuario
		$('body').on('click','.deleteUserIcon',function(e){
			e.preventDefault();
			delete_id = $(this).attr('id');
			Swal.fire({
				title : '¿Deseas borrar el usuario?',
				text : 'Deseas Borrar el usuario',
				type : 'warning',
				showCancelButton : true,
				confirmButtonColor : '#3085d6',
				cancelButtonColor : '#d33',
				confirmButtonText : 'Eliminar Cuenta',
			}).then(result=>{
				if(result.value){
					$.ajax({
						url : 'assets/php/admin-action.php',
						method : 'post',
						data : { delete_id, delete_id },
						success : function(response){
							Swal.fire(
									'Borrado!!!',
									'Usuario Eliminado del sistema',
									'success'
								)
							traertodoslosusuarios();
						}
					});
				}
			});
		});

	});
</script>