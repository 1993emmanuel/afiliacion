<!DOCTYPE html>
<html>
<head>
	<title>Login | Admin</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/css/bootstrap.min.css">
  	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
  	<style type="text/css">
  		html,body{	height: 100%;	}
  	</style>
</head>
<body class="bg-dark">

	<div class="container h-100">
		<div class="row h-100 align-items-center justify-content-center">
			<div class="col-lg-5">
				<div class="card border-danger shadow-lg">
					<div class="card-header bg-danger">
						<h3 class="m-0 text-white"><i class="fas fa-user-cog"></i>&nbsp;Admin Panel Login</h3>
					</div>
					<div class="card-body">
						<form action="" method="post" class="px-3" id="admin-login-form">
							<div id="adminLoginAlert"></div>
							<div class="form-group">
								<input type="text" name="username" class="form-control form-control-lg rounder-0" placeholder="Nombre de usaurio" required autofocus pattern="[a-zA-Z0-9]{1,35}" maxlength="35">
							</div>
							<div class="form-group">
								<input type="password" name="password" placeholder="Ingrse la contraseña" required class="form-control form-control-lg" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100">
							</div>
							<div class="form-group">
								<input type="submit" name="admin-login" class="btn btn-danger btn-block btn-lg rounder-0" value="Login" id="adminLoginBtn">
							</div>
						</form>
					</div>
					
				</div>
			</div>
		</div>
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/js/all.min.js"></script>

<script type="text/javascript">
	$(document).ready(function(){
		$('#adminLoginBtn').click(function(e){
			if( $('#admin-login-form')[0].checkValidity() ){
				e.preventDefault();
				$(this).val('Ingresando.........');
				$.ajax({
					url : 'assets/php/admin-action.php',
					method : 'post',
					data : $('#admin-login-form').serialize()+'&action=adminLogin',
					success:function(response){
						if( response == 'admin_login' ){
							window.location = 'admin-dashboard.php';
						}else{
							$('#adminLoginAlert').html(response);
						}
						$(this).val('Login');
					}
				});
			}
		});
	});
</script>

</body>
</html>