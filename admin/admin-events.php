<?php
	require_once "assets/php/admin-header.php";
	require_once "assets/php/admin-db.php";
	$count = new Admin();
?>

<div class="container">
	<div class="row">
		<div class="col-lg-12 my-2">
			<div class="card-header bg-dark d-flex justify-content-between">
				<span class="text-light lead align-self-center">Todos los eventos</span>
				<a href="#" class="btn btn-light" data-toggle="modal" data-target="#addEventoModal">
					<i class="fas fa-plus-circle fa-lg"></i>&nbsp;Agregar Evento
				</a>
			</div>
			<div class="card-body">
				<div class="table-responsive" id="mostrarTodoslosEventos">
					<p class="text-center lead mt-5">Espere un momento porfavor...............</p>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="addEventoModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h4 class="modal-title text-light">Agregar Evento</h4>
				<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post" class="px-3" id="add-event-form">
					<div class="form-group">
						<input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="Ingrese el titulo del evento" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,90}">
					</div>
					<div class="form-group">
						<input type="text" name="costo" id="costo" class="form-control form-control-lg" placeholder="Ingrese el costo del evento" required>
					</div>
					<div class="form-group">
						<textarea name="descripcion" class="form-control form-control-lg" placeholder="ingrese una descripcion del evento." rows="6"></textarea>
					</div>
					<div class="form-group">
						<label for="inicioEvento">Ingrese el inicio del evento</label>
						<input type="date" id="inicioEvento" name="inicioEvento" class="form-control form-control-lg" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))">
					</div>
					<div class="form-group">
						<label for="finEvento">Ingrese el final del evento</label>
						<input type="date" name="finEvento" id="finEvento" class="form-control form-control-lg" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))">
					</div>
					<div class="form-control">
						<input type="submit" name="subir_evento" value="Guardar Evento" class="btn btn-outline-success btn-block" id="subirEventoBtn">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="editEventoModal">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-dark">
				<h4 class="modal-title text-light">Editar Evento</h4>
				<button type="button" class="close text-light" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<form action="#" method="post" class="px-3" id="edit-event-form">
					<input type="hidden" name="edit_id" id="edit_id">
					<div class="form-group">
						<input type="text" name="title" id="edit_title" class="form-control form-control-lg" placeholder="Ingrese el titulo del evento" required pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,90}">
					</div>
					<div class="form-group">
						<input type="text" name="costo" id="edit_costo" class="form-control form-control-lg" placeholder="Ingrese el costo del evento" required>
					</div>
					<div class="form-group">
						<textarea id="edit_evento" name="descripcion" class="form-control form-control-lg" placeholder="ingrese una descripcion del evento." rows="6"></textarea>
					</div>
					<div class="form-group">
						<label for="inicioEvento">Ingrese el inicio del evento</label>
						<input type="date" id="edit_inicioEvento" name="inicioEvento" class="form-control form-control-lg" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))">
					</div>
					<div class="form-group">
						<label for="finEvento">Ingrese el final del evento</label>
						<input type="date" name="finEvento" id="edit_finEvento" class="form-control form-control-lg" required pattern="(?:19|20)[0-9]{2}-(?:(?:0[1-9]|1[0-2])-(?:0[1-9]|1[0-9]|2[0-9])|(?:(?!02)(?:0[1-9]|1[0-2])-(?:30))|(?:(?:0[13578]|1[02])-31))">
					</div>
					<div class="form-control">
						<input type="submit" name="subir_evento" value="Editar Evento" class="btn btn-outline-success btn-block" id="editarEventoBtn">
					</div>
				</form>
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

		MostrarTodoslosEventos();
		//Funcion para mostrar todos los eventos
		function MostrarTodoslosEventos(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : {action : 'allevent'},
				success:function(response){
					$('#mostrarTodoslosEventos').html(response);
					$('table').DataTable({
						order: [0 , 'desc']
					});
				}
			});
		}

		//Guardar el evento
		$('#subirEventoBtn').click(function(e){
			if( $('#add-event-form')[0].checkValidity() ){
				e.preventDefault();
				$('#subirEventoBtn').val('Generando Evento........');
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#add-event-form').serialize()+'&action=guardar_evento',
					success:function(response){
						$('#subirEventoBtn').val('Guardar Evento');
						$('#add-event-form')[0].reset();
						$('#addEventoModal').modal('hide');
						Swal.fire({
							title : 'Evento generado correctamente',
							type : 'success'
						});
						MostrarTodoslosEventos();
					}
				});
			}
		});


		//mostrar el modal para editar
		$('body').on('click','.eventDetailsIcon',function(e){
			e.preventDefault();
			editEvent_id = $(this).attr('id');
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { editEvent_id : editEvent_id },
				success:function(response){
					data = JSON.parse(response);
					$('#edit_id').val(data.id);
					$('#edit_title').val(data.nombreEvento);
					$('#edit_costo').val(data.costo);
					$('#edit_evento').val(data.descripcion);
					$('#edit_inicioEvento').val(data.finicio);
					$('#edit_finEvento').val(data.ffinal);
				}
			})
		});

		//Editar el evento
		$('#editarEventoBtn').click(function(e){
			if( $('#edit-event-form')[0].checkValidity() ){
				e.preventDefault();
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#edit-event-form').serialize()+'&action=edit_evento',
					success:function(response){
						Swal.fire({
							title : 'Evento Actualizado!!!',
							type : 'success'
						});
						$('#edit-event-form')[0].reset();
						$('#editEventoModal').modal('hide');
						MostrarTodoslosEventos();
					}
				});
			}
		});

		//Eliminar un evento
		$('body').on('click','.deleteEventIcon',function(e){
			e.preventDefault();
			eventDelete_id = $(this).attr('id');
			Swal.fire({
		  		title: '¿Deseas Eliminar el evento?',
		  		type: 'warning',
		  		showCancelButton: true,
		  		confirmButtonColor: '#3085d6',
		  		cancelButtonColor: '#d33',
		  		confirmButtonText: 'Si eliminar evento!!!'
			}).then((result) => {
		  		if (result.value) {
		  			$.ajax({
		  				url : 'assets/php/admin-action.php',
		  				method : 'post',
		  				data : { eventDelete_id : eventDelete_id },
		  				success:function(response){
		  					Swal.fire(
		  						'Evento Eliminado!!!',
		  						'El evento fue eliminado correctamente',
		  						'success'
		  					);
		  					MostrarTodoslosEventos();
		  				}
		  			});
		  		}
			});
		});

	});
</script>