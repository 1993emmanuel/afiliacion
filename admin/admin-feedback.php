<?php
	require_once "assets/php/admin-header.php";
	require_once "assets/php/admin-db.php";
	$count = new Admin();
?>

	<div class="row">
		<div class="col-lg-12">
			<div class="mt-3" id="feedbackAlerta"></div>
			<div class="card border-dark my-2">
				<div class="card-header bg-dark text-white"><h4 class="m-0">Total de feedback enviados por usuarios</h4></div>
				<div class="card-body">
					<div class="table-responsive" id="showAllFeedback">
						<p class="text-center align-self-center lead">Cargando Mensajes.........</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	

	<div class="modal fade" id="showReplayModal">
		<div class="modal-dialog modal-dialog-centered">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Contestar Feedback</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<div class="modal-body">
					<form action="#" method="post" class="px-3" id="feedback-replay-form">
						<div class="form-group">
							<textarea name="message" id="message" class="form-control" rows="6" placeholder="Ingresa tu respuesta" required></textarea>
						</div>
						<div class="form-group">
							<input type="submit" name="submit" value="Enviar Respuesta" class="btn btn-outline-success btn-block" id="feedbackReplyBtn">
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

		mostrarTodoslosFeedbacks();

		///funcion para mostrar todos los feedbacks
		function mostrarTodoslosFeedbacks(){
			$.ajax({
				url : 'assets/php/admin-action.php',
				method : 'post',
				data : { action : 'mostrarFeedbacks' },
				success:function(response){
					$('#showAllFeedback').html(response);
					$('table').DataTable({
						order : [0 , 'desc']
					});
				}
			});
		}

		//funcion para contestar y enviar el mensaje.
		var uid;
		var fid;
		$('body').on('click','.replyFeedbackIcon',function(e){
			uid = $(this).attr('id');
			fid = $(this).attr('fid');

			$('#feedbackReplyBtn').click(function(e){
				if( $('#feedback-replay-form')[0].checkValidity() ){
					let message = $('#message').val();
					e.preventDefault();
					$('#feedbackReplyBtn').val('Enviando Mensaje.............');
					$.ajax({
						url : 'assets/php/admin-action.php',
						method : 'post',
						data : { uid: uid, message : message, fid : fid },
						success : function(response){
							$('#feedbackReplyBtn').val('Enviar Respuesta');
							$('#showReplayModal').modal('hide');
							$('#feedback-replay-form')[0].reset();
							$('#feedbackAlerta').html(response);
							mostrarTodoslosFeedbacks();
						}
					});
				}
			});
		});

	});
</script>

