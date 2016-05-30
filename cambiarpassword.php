<?php 
include 'includes/conexion.php';
include 'includes/header.php';
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];

if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
?>

    <div class="container" role="main">
      <div class="col-md-2"></div>
      <div class="col-md-8">
<?php
	
	$sql = "SELECT * FROM resetpass WHERE idusuario = '$idusuario'";
	$resultado = $conexion->query($sql);
	
	if( $resultado->num_rows > 0 ){
		$usuario = $resultado->fetch_assoc();
		
			if( $password1 === $password2 ){
				$sql = "UPDATE usuario SET password = '".md5($password1)."' WHERE id = ".$usuario['idusuario'];
				$resultado = $conexion->query($sql);
				if($resultado){
					$sql = "DELETE FROM resetpass WHERE idusuario = '$idusuario';";
					$resultado = $conexion->query( $sql );
				?>
					<p> La contraseña se actualizó con exito. </p>
				<?php	
				}
				
			}
			else{
			?>
			<p> Las contraseñas no coinciden </p>		
	<?php	
	}	
	}
	?>
	</div>
<div class="col-md-2"></div>
	</div> <!-- /container -->
<script src="js/jquery-1.11.1.js"></script>
    <script src="js/bootstrap.min.js"></script>
<?php
	include 'includes/footer.php'
	?>
<?php
}
?>