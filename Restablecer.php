<?php 
	
	include 'includes/conexion.php';
	include 'includes/header.php';
	$token = $_GET['token'];	
	$idusuario = $_GET['idusuario'];
	
	$resultado = $conexion->query("SELECT * FROM resetpass WHERE token = '$token'");
	
	if( $resultado->num_rows > 0 ){
		$usuario = $resultado->fetch_assoc();		
?>
    <br>
    <div class="container">
      <div class="col-md-4 col-md-offset-4">
        <form action="/Cambiar.php" method="post">
          <div class="panel panel-default">
            <div class="panel-body">
              <h5>Restaurar contraseña</h5>
              <hr>
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
                <input type="submit" class="btn btn-success btn-block" value="Recuperar contraseña">
              </div>
            </div>
          </div>
        </form>  
      </div>
    </div>
  	<?php
    include 'includes/footer.php';
  }else{
  	header('Location:index.php');
  }
?>
