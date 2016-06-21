<?php 
include 'includes/conexion.php';
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];

if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
  include 'includes/header.php';
  $resultado = $conexion->query(" SELECT * FROM resetpass WHERE token = '$token' ");
  ?>
  <br>
  <div class="container main">
    <div class="col-md-8 col-md-offset-2">
      <?php 
      if( $resultado->num_rows > 0 ){

        $usuario = $resultado->fetch_assoc();

        if( sha1( $usuario['usuario_id'] ) === $idusuario  ){
          if( $password1 === $password2 ){
            $conexion->query("UPDATE usuario SET password = '".md5($password1)."' WHERE id = ".$usuario['usuario_id']);
            $conexion->query("DELETE FROM resetpass WHERE token = '$token';");
			$mjs = '<div class="alert alert-success">La contraseña se actualizó con exito. </div>';
            ?>
			
			
			<?php 	
			echo "$mjs";
			header( "refresh:1; url=index.php" );
			?>
            <?php
          }else{$mjs = '<div class="alert alert-danger"> Las contraseñas no coinciden  </div>';
            ?><?php
			echo "$mjs";
			header( "refresh:1; url=restablecer.php?idusuario=$idusuario&token=$token" );
          }
        }else{
          ?><div class="alert alert-danger"> El token no es válido </div><?php
        } 
      }else{
        ?><div class="alert alert-danger"> El token no es válido </div><?php
      } ?>
    </div>
  </div>

<?php include 'includes/footer.php';

}else{
  header('Location: /');
}
?>