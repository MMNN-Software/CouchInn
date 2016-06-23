<?php 
include 'includes/conexion.php';
$password1 = $_POST['password1'];
$password2 = $_POST['password2'];
$idusuario = $_POST['idusuario'];
$token = $_POST['token'];

if( $password1 != "" && $password2 != "" && $idusuario != "" && $token != "" ){
  include 'includes/header.php';
  $sql = " SELECT * FROM resetpass WHERE token = '$token' ";
  $resultado = $conexion->query($sql);
  ?>
  <br>
  <div class="container" role="main">
    <div class="col-md-8 col-md-offset-2">
      <?php 
      if( $resultado->num_rows > 0 ){

        $usuario = $resultado->fetch_assoc();

        if( sha1( $usuario['idusuario'] ) === $idusuario ) ){
          if( $password1 === $password2 ){
            $conexion->query("UPDATE usuario SET password = '".md5($password1)."' WHERE id = ".$usuario['idusuario']);
            $conexion->query("DELETE FROM resetpass WHERE token = '$token';");
            ?><p> La contraseña se actualizó con exito. </p>
			<?php
			sleep(2);
			header('Location: index.php');?>
		
          <?php}else{
            ?><p> Las contraseñas no coinciden </p><?php
          }
        }else{
          ?><p> El token no es válido1 </p><?php
        } 
      }else{
        ?><p> El token no es válido2 </p><?php
      } ?>
    </div>
  </div>

<?php include 'includes/footer.php';

}else{
  header('Location: /');
}
?>