<?php
	include_once "assets/php/header.php";
?>


<div class="container">
	<div class="row">
		<div class="col-lg-12 mt-3">
			<div id="Alertafeedback" class="mt-1 mb-1"></div>
			<?php if ($verified === 'No verificado'): ?>
				<div class="alert alert-danger alert-dismissible text-center mt-2 m-0">
					<button class="close" type="button" data-dismiss="alert">&times;</button>
					<strong>
						Tu Email aun no esta verificado, Necesitas subir tu informacion en perfil y esperar que un administrador valide tu informacion.
					</strong>
				</div>
			<?php else:	?>
				<div class="card border-dark">
					<div class="card-header lead bg-dark text-center text-white">Enviar mensaje al admin</div>
					<div class="card-body">
						
						<form action="#" method="post" class="px-4" id="feedback-form">
							<div class="form-group">
								<input type="text" name="subject" placeholder="Titulo del mensaje" class="form-control form-control-lg rounder-0" required>
							</div>
							<div class="form-group">
								<textarea name="feedback" class="form-control form-control-lg rounder-0" rows="8" placeholder="Ingresa tu mensaje en esta parte" required></textarea>
							</div>
							<div class="form-group">
								<input type="submit" name="feedbackBtn" value="Enviar Mensaje" class="btn btn-outline-success btn-block btn-lg rounder-0" id="feedbackBtn">
							</div>
						</form>

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
		//Enviar el feedback a la base de datos
		$('#feedbackBtn').click(function(e){
			if( $('#feedback-form')[0].checkValidity() ){
				e.preventDefault();
				$(this).val('Enviando mensaje..........');
				$.ajax({
					url : 'assets/php/process.php',
					method : 'post',
					data : $('#feedback-form').serialize()+'&action=feedback',
					success:function(response){
						$('#Alertafeedback').html(response);
						$('#feedback-form')[0].reset();
						$('#feedbackBtn').val('Enviar Mensaje');
					}
				});
			}
		});
	});
</script>