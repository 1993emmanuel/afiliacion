<?php
	include_once "assets/php/header.php";
?>

<div class="container">
	<div class="row justify-content-center">
		<div class="col-lg-10">
			<div class="card rounder-0 mt-3 border-dark">
				<div class="card-header border-dark">
					<ul class="nav nav-tabs card-header-tabs">
						<li class="nav-item">
							<a href="#profile" class="nav-link active font-weight-bold" data-toggle="tab">
								<i class="fas fa-user fa-lg"></i>&nbsp;Perfil
							</a>
						</li>
						<li class="nav-item">
							<a href="#editProfile" class="nav-link font-weight-bold" data-toggle="tab">
								<i class="fas fa-edit fa-lg"></i>&nbsp;Editar Perfil
							</a>
						</li>
						<li class="nav-item">
							<a href="#changePass" class="nav-link font-weight-bold" data-toggle="tab">
								<i class="fas fa-key fa-lg"></i>&nbsp;Cambiar Contraseña
							</a>
						</li>
						<li class="nav-item">
							<a href="#filesPDF" class="nav-link font-weight-bold" data-toggle="tab">
								<i class="fas fa-file-pdf fa-lg"></i>&nbsp;Archivos
							</a>
						</li>
						<li class="nav-item">
							<a href="#complementarios" class="nav-link font-weight-bold" data-toggle="tab">
								<i class="fas fa-id-card fa-lg"></i>&nbsp;Complementarios
							</a>
						</li>
					</ul>
				</div>
				<!-- Cuerpo de las tabs -->
				<div class="card-body">
					<div class="tab-content">
						<div class="tab-pane container active" id="profile">
							<div id="verifyEmailAlert"></div>
							<div class="card-deck">
								<div class="card border-dark">
									<div class="card-header bg-dark text-light text-center lead">
										User ID <?= $cid; ?>
									</div>
									<div class="card-body">
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>Nombre : </b><?= $cname; ?>
										</p>
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>Numero de Telefono : </b> <?= $cphone; ?>
										</p>
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>Genero : </b> <?= $cgender; ?>
										</p>
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>Numero del Padre : </b> <?= $cfatherphone; ?>
										</p>
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>Fecha de nacimiento : </b> <?= $cdob; ?>
										</p>
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>CURP : </b> <?= $ccurp; ?>
										</p>
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>Fecha de Afiliacion : </b> <?= $reg_on; ?>
										</p>
										<p class="card-text p-2 m-1 rounder" style="border: 1px solid #000;">
											<b>Cuenta Verificada : </b> <?= $verified; ?>
										</p>
									</div>
									<div class="clearfix"></div>
								</div>
								<div class="card border-dark align-self-center">
									<?php if ( !$cphoto ) : ?>
										<img src="assets/img/MaleAvatar.png" class="img-thumbnail img-fluid" width="350px">
									<?php else: ?>
										<img src="<?= 'assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="350px">
									<?php endif; ?>
								</div>
							</div>
						</div>

						<div class="tab-pane container" id="editProfile">
							<div class="card-deck">
								<div class="card border-dark align-self-center">
									<?php if ( !$cphoto ) : ?>
										<img src="assets/img/MaleAvatar.png" class="img-thumbnail img-fluid" width="350px">
									<?php else: ?>
										<img src="<?= 'assets/php/'.$cphoto; ?>" class="img-thumbnail img-fluid" width="350px">
									<?php endif; ?>
								</div>
								<div class="card border-dark">
									<!-- Formulario para las fotos -->
									<form action="#" method="POST" class="px-3 mt-2" enctype="multipart/form-data" id="profile-update-form">
										<input type="hidden" name="oldimage" value="<?= $cphoto; ?>">
										<div class="form-group m-0">
											<label for="profilePhoto" class="m-1">Upload Profile Image</label>
											<input type="file" name="image" id="profilePhoto">
										</div>

										<div class="form-group">
											<label for="name" class="m-1">Name</label>
											<input type="text" name="name" id="name" class="form-control" value="<?= $cname; ?>" maxlength="35" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{1,35}">
										</div>

										<div class="form-group">
											<label for="gender" class="m-0">Gender</label>
											<select  name="gender" id="gender" class="form-control">
												<option value="" disabled <?php if($cgender==null){echo 'selected';} ?> >Select</option>
												<option value="Male" <?php if($cgender=='Male'){echo 'selected';} ?> >Male</option>
												<option value="Female" <?php if($cgender=='Female'){echo 'selected';} ?> >Female</option>
											</select>
										</div>

										<div class="form-group m-0">
											<label for="dob" class="m-1">Date of Birth</label>
											<input type="date" id="dob" name="dob" value="<?= $cdob; ?>" class="form-control">
										</div>

										<div class="form-group m-0">
											<label for="phone" class="m-1">Phone</label>
											<input type="tel" id="phone" name="phone" value="<?= $cphone; ?>" class="form-control" placeholder="Phone" pattern="[0-9()+]{8,20}" maxlength="20">
										</div>
										
										<div class="form-group mt-2">
											<input type="submit" name="profile_update" value="Update Profile" class="btn btn-danger btn-block" id="profileUpdateBtn">
										</div>


									</form>
									<!-- Final del formulario de las fotos -->
								</div>
								
							</div>
						</div>

						<div class="tab-pane container" id="changePass">
							<div id="changePassAlert"></div>
							<div class="card-deck">
								<div class="card border-dark">
									<div class="card-header bg-dark text-light text-center lead">Cambiar Contraseña </div>
									<!-- Inicio Formulario del cambio de las contraseñas -->
									<form action="#" method="post" class="px-3 mt-2" id="change-pass-form">

										<div class="form-group">
											<label for="curpass">Ingresa tu contraseña Actual</label>
											<input type="password" name="curpass" placeholder="Ingresa tu contraseña actual" class="form-control form-control-lg" id="curpass" required pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
										</div>

										<div class="form-group">
											<label for="newpass">Ingresa tu nuevo password</label>
											<input type="password" name="newpass" placeholder="Nueva contraseña" class="form-control form-control-lg" id="newpass" required pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
										</div>

										<div class="form-group">
											<label for="cnewpass">Confirmar su contraseña nueva</label>
											<input type="password" name="cnewpass" placeholder="Confimar nueva contraseña" class="form-control form-control-lg" id="cnewpass" required pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
										</div>

										<div class="form-group">
											<p id="changepassError" class="text-danger font-weight-bold"></p>
										</div>

										<div class="form-group">
											<input type="submit" name="changepass" value="Cambiar Contraseña" class="btn btn-outline-success btn-block btn-lg" id="changePassBtn">
										</div>

									</form>
									<!-- Final Formulario del cambio de las contraseñas -->
								</div>
							</div>
						</div>

						<div class="tab-pane container" id="filesPDF">
							<div id="changeFilesAlert"></div>
							<div class="card-deck">
								<div class="card border-dark">
									<div class="card-header bg-dark text-white text-center lead">Subir Archivos</div>
									<form action="#" method="post" class="px-3 mt-2" enctype="multipart/form-data" id="subir-archivos-form">
										<input type="hidden" name="oldfileacta" value="<?= $cacta; ?>">
										<input type="hidden" name="oldfilepago" value="<?= $ccomprobante; ?>">
										<div class="form-group">
											<label for="actaFile">Ingrese el archivo del acta de nacimiento.</label>
											<input type="file" name="acta" id="actafile" class="form-control form-control-lg">
										</div>
										<br>
										<div class="form-group">
											<label for="pagoFile">Ingrese el archivo con el pago realizado.</label>
											<input type="file" name="pago" id="pagofile" class="form-control form-control-lg">
										</div>
										<div class="form-group">
											<input type="submit" name="subirArchivos" value="Subir Archivos" class="btn btn-outline-success btn-block btn-lg" id="subirArchivosBtn">
										</div>
									</form>
								</div>
							</div>
						</div>
						
						<div class="tab-pane container" id="complementarios">
							<div id="complementariosAlert"></div>
							<div class="card-deck">
								<div class="card border-dark">
									<div class="card-header bg-dark text-white text-center lead">Datos Complementarios</div>
									<div class="card-body">
										<form accept="#" method="post" class="px-3 mt-2" id="change-complementario-form">
											<div class="form-group">
												<label for="phoneFather">Ingrese numero de telefono del padre</label>
												<input type="tel" name="phoneFather" placeholder="Ingrese el contacto del tutor" class="form-control form-control-lg" required minlength="10" id="phoneFather" value="<?= $cfatherphone; ?>" pattern="[0-9()+]{8,20}" maxlength="20" >
											</div>
											<div class="form-group">
												<label for="curp">CURP</label>
												<input type="text" name="curp" placeholder="Ingrese su Curp" class="form-control form-control-lg" required minlength="18" value="<?= $ccurp; ?>" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,#\- ]{1,18}" >
											</div>
											<div class="form-group">
												<input type="submit" name="changecomplementarios" value="Guardar Datos Complementarios" class="btn btn-outline-success btn-lg btn-block" id="changeComplementariosBtn">
											</div>
										</form>
									</div>
								</div>
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

		/*
			Editar Perfil Form
		*/
		$('#profile-update-form').submit(function(e){
			e.preventDefault();
			$.ajax({
				url : 'assets/php/process.php',
				method : 'POST',
				processData : false,
				contentType : false,
				cache : false,
				data : new FormData(this),
				success:function(response){
					location.reload();
				}
			});
		});

		/*
			Subir Archivos Acta de nacimiento y Comprobante de pago
		*/
		$('#subir-archivos-form').submit(function(e){
			e.preventDefault();
			$.ajax({
				url : 'assets/php/process.php',
				method : 'POST',
				processData : false,
				contentType  : false,
				cache : false,
				data : new FormData(this),
				success : function(response){
					location.reload();
				}
			});
		});


		/*
			Change Password Ajax Request
		*/
		$('#changePassBtn').click(function(e){
			$('#changepassError').text('');
			if( $('#change-pass-form')[0].checkValidity() ){
				e.preventDefault();
				$('#changePassBtn').val('Guardando cambios.........');
				if( $('#newpass').val() != $('#cnewpass').val() ){
					$('#changepassError').text('* Las contraseñas no coinciden!');
					$('#changePassBtn').val('Cambiar Contraseña');
				}else{
					$.ajax({
						url : 'assets/php/process.php',
						method: 'post',
						data : $('#change-pass-form').serialize()+'&action=change_pass',
						success:function(response){
							$('#changePassAlert').html(response);
							$('#changePassBtn').val('Cambiar Contraseña');
							$('#changepassError').text('');
							$('#change-pass-form')[0].reset();
						}
					});
				}
			}else{
				$('#changepassError').text('* Para cambiar contraseña los valores son requeridos!');
			}
		});


		/*
			Cambiar Datos Complementarios Ajax Request
		*/
		$('#changeComplementariosBtn').click(function(e){
			if ( $('#change-complementario-form')[0].checkValidity() ){
				e.preventDefault();
				$('#changeComplementariosBtn').val("Procesando Espere........");
				$.ajax({
					url : 'assets/php/process.php',
					method: 'post',
					data : $('#change-complementario-form').serialize()+'&action=change_complementarios',
					success:function(response){
						location.reload();
					}
				})
			}
		});

	});

</script>
