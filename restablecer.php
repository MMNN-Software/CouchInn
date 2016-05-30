<?php 
	
	include 'includes/conexion.php';
	include 'includes/header.php';
	$token = $_GET['token'];	
	$idusuario = $_GET['idusuario'];
	
	$sql = "SELECT * FROM resetpass WHERE token = '$token'";
	$resultado = $conexion->query($sql);
	
	if( $resultado->num_rows > 0 ){
		$usuario = $resultado->fetch_assoc();		
?>

    <div class="container" role="main">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form action="/cambiarpassword.php" method="post">
          <div class="panel panel-default">
            <div class="panel-heading"> Restaurar contraseña </div>
            <div class="panel-body">
              <p></p>
              <div class="form-group">
                <label for="password"> Nueva contraseña </label>
                <input type="password" class="form-control" name="password1" autocomplete="off" required>
              </div>
              <div class="form-group">
                <label for="password2"> Confirmar contraseña </label>
                <input type="password" class="form-control" name="password2" autocomplete="off" required>
              </div>
              <input type="hidden" name="token" value="<?php echo $token ?>">
              <input type="hidden" name="idusuario" value="<?php echo $idusuario ?>">
              <div class="form-group">
                <input type="submit" class="btn btn-success btn-block" value="Recuperar contraseña" >
              </div>
            </div>
          </div>
        </form>  
      </div>
      <div class="col-md-4"></div>

    </div> <!-- /container -->

    <script src="js/jquery-1.11.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
	<?php
include 'includes/footer.php';
?>
<?php	
		}
	else{
		header('Location:index.php');
	}
?>
