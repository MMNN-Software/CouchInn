<?php
  include 'includes/conexion.php';
  include 'includes/functions.php';

  //include 'includes/isUser.php';


  function luhn_check($number) {
    return true;
    $number=preg_replace('/\D/', '', $number);
    $number_length=strlen($number);
    $parity=$number_length % 2;
    $total=0;
    for ($i=0; $i<$number_length; $i++) {
      $digit=$number[$i];
      if ($i % 2 == $parity) {
        $digit*=2;
        if ($digit > 9) {
          $digit-=9;
        }
      }
      $total+=$digit;
    }
    return ($total % 10 == 0) ? TRUE : FALSE;
  }

  
  if(isset($_FILES['profile_picture'])){
    $archivo = $_FILES['profile_picture'];
    $nombre = md5($_SESSION['id']).'.jpg';
    $imgSrc = 'img/perfiles/'.$nombre;
    switch ($archivo['type']) {

      case 'image/jpg':
        $myImage = imagecreatefromjpeg($archivo['tmp_name']);
        break;

      case 'image/jpeg':
        $myImage = imagecreatefromjpeg($archivo['tmp_name']);
        break;

      case 'image/gif':
        $myImage = imagecreatefromgif($archivo['tmp_name']);
        break;

      case 'image/png':
        $myImage = imagecreatefrompng($archivo['tmp_name']);
        break;
      
      default:
        $error = "Tipo de archivo no soportado.";
        break;
    }

    if(empty($error)){
      list($width, $height) = getimagesize($archivo['tmp_name']);
      if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
      } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
      }
      $thumbSize = 480;
      $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
      imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
      imagejpeg($thumb,$imgSrc,90);
      $conexion->query("UPDATE usuario SET foto = '{$nombre}' WHERE id = '{$_SESSION['id']}';");
      header("Location: /Perfil.php");
      die;
    }
  }

  if(isset($_POST['update'])){
    $nombre = $conexion->real_escape_string(strip_tags(trim($_POST['nombre'])));
    $dni = $conexion->real_escape_string(strip_tags(trim($_POST['dni'])));
    $domicilio = $conexion->real_escape_string(strip_tags(trim($_POST['domicilio'])));
    $religion = $conexion->real_escape_string(strip_tags(trim($_POST['religion'])));
    $sexo = $conexion->real_escape_string($_POST['sexo']);
    $biografia = $conexion->real_escape_string(strip_tags(trim($_POST['biografia']), '<b><i>'));
    $conexion->query("UPDATE usuario SET nombre='{$nombre}',dni='{$dni}',domicilio='{$domicilio}',religion='{$religion}',sexo='{$sexo}',biografia='{$biografia}' WHERE id = '{$_SESSION['id']}' ");
    $usuario = $conexion->query("SELECT * FROM usuario WHERE id = '{$_SESSION['id']}'");
    doLoginOf($usuario->fetch_assoc());
    $mensaje = "Tus datos fueron actualizados correctamente.";
  }


  if(isset($_POST['pass'])){
    $usuario = $conexion->query("SELECT * FROM usuario WHERE id = '{$_SESSION['id']}'");
    $usuario = $usuario->fetch_assoc();

    if( strlen($_POST['pass']) < 6 ){
      $error = "La nueva contraseña es demasiado corta";
    }

    if( md5($_POST['pass']) != $usuario['password'] ){
      $error = "La contraseña ingresada no corresponde a tu cuenta";
    }

    if( md5($_POST['npass']) != md5($_POST['nrepass']) ){
      $error = "Las contraseñas ingresadas no coinciden";
    }

    if(empty($error)){
      $pass = $conexion->real_escape_string($_POST['npass']);
      $conexion->query("UPDATE usuario SET password = MD5('{$pass}') WHERE id = '{$_SESSION['id']}'");
      $mensaje = "Tu contraseña fue actualizada correctamente";
    }
  }

  if(isset($_POST['tarjeta'])){
    $pagos = $conexion->query("SELECT * FROM pago WHERE usuario_id = '{$_SESSION['id']}'");

    if($pagos->num_rows){
      $error = "Ya sos premium";
    }

    if( !preg_match("/^[0-9]{16}$/", $_POST['tarjeta']) or !luhn_check($_POST['tarjeta'])){
      $error = "El número de tarjeta parece ser inválido";
    }
    if( !preg_match("/^([01][0-2]|0?[1-9])\/[1-5][0-9]$/", $_POST['expires']) ){
      $error = "La fecha de vencimiento de la tarjeta parece ser inválida";
    }
    if( !preg_match("/^[0-9]{3,4}$/", $_POST['ccv']) ){
      $error = "El numero verificador parece ser inválido";
    }

    if(empty($error)){
      $hoy = date("Y-m-d H:i:s");
      $conexion->query("INSERT INTO pago(id, usuario_id, fecha, monto, tarjeta) VALUES (NULL,'{$_SESSION['id']}','{$hoy}',150,'{$_POST['tarjeta']}')");
      $conexion->query("UPDATE usuario SET premium = 1 WHERE id = '{$_SESSION['id']}'");
      $mensaje = "Tu usuario ahora es premium.";
	  $_SESSION['premium'] = 1;
    }
  }

  if(isset($_POST['valorar'])){
    $mensaje1 = $conexion->real_escape_string($_POST['mensaje']);
    $valor = $_POST['valoracion'];

    $hoy = date("Y-m-d");
    $conexion->query("INSERT INTO valoracion (reserva_id, origen_usuario_id, destino_usuario_id, fecha,valor, mensaje) VALUES ('{$_POST['rid']}', '{$_SESSION['id']}', '{$_POST['uid']}', '$hoy', '{$_POST['valoracion']}', '{$mensaje1}')");
    $mensaje = "Tu valoración se ha enviado con éxito"; 
  }

  if(isset($_POST['borrar_favorito'])){
    $conexion->query("DELETE FROM favorito WHERE id = '{$_POST['borrar_favorito']}'");
    if($conexion->affected_rows) $mensaje = "La publicación ha sido borrada de favoritos"; 
  }

  $iduser = $conexion->real_escape_string((isset($_GET['id']))?$_GET['id']:$_SESSION['id']);

  $usuario_perfil = $conexion->query("SELECT * FROM usuario WHERE id = '{$iduser}'");
  if($usuario_perfil->num_rows){
    $usuario_perfil = $usuario_perfil->fetch_assoc();
    $ismyprofile = !isset($_GET['id']) or $_GET['id'] == $_SESSION['id'];
  }else{
    $error = "El usuario no se ha encontrado";
  }

  include 'includes/header.php';?>

  <?php if ($ismyprofile): ?>
    <?php include 'includes/form_premium.php';?>
    <?php include 'includes/form_baja.php'; ?>
    <?php include 'includes/form_pass.php'; ?>
  <?php endif; ?>

  <div class="container main">
    <?php if (!empty($error)): ?>
      <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $error ?>
      </div>
    <?php endif ?>
    <?php if (!empty($mensaje)): ?>
      <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $mensaje ?>
      </div>
    <?php endif ?>

      
    <div class="row">
      <div class="col-sm-4 col-lg-3">
        <div class="panel panel-success">
          <?php if ($ismyprofile): ?>
          <form action="/Perfil.php" method="POST" enctype="multipart/form-data" id="changeProfilePicture">
            <div class="profile-picture img-circle shadow">
              <img src="/img/perfiles/<?php echo ($usuario_perfil['foto'])?$usuario_perfil['foto']:'default.png'; ?>">
              <span class="mensaje-upload"><span class="glyphicon glyphicon-camera"></span> Subir</span>
              <input type="file" name="profile_picture" accept="image/*">
            </div>
          </form>
          <?php else: ?>
            <div id="changeProfilePicture">
              <div class="profile-picture img-circle shadow">
                <img src="/img/perfiles/<?php echo ($usuario_perfil['foto'])?$usuario_perfil['foto']:'default.png'; ?>">
              </div>
            </div>
          <?php endif; ?>
          <div class="profile-usertitle">
            <div class="profile-usertitle-name">
              <?php echo $usuario_perfil['nombre'] ?>
            </div>
            <div class="profile-usertitle-job">
              <?php if ($usuario_perfil['tipo'] == 'admin'): ?>
                Usuario Administrador
              <?php elseif ($usuario_perfil['premium']): ?>
			    Usuario Premium
			  <?php else: ?>
                Usuario Base
              <?php endif ?>
            </div>
          </div>
          
          <?php if ($ismyprofile): ?>
          <div class="profile-userbuttons">
            <?php if (!$usuario_perfil['premium']): ?>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#mejorarCuenta">Mejorar cuenta</button>
            <?php endif; ?>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#darDeBaja">Dar de baja</button>
          </div>
          <?php endif ?>

          <div class="profile-usermenu">
            <ul class="nav">
              <li<?php if ( !isset($_GET['tab']) ): ?> class="active"<?php endif; ?>><a href="/Perfil.php"><i class="glyphicon glyphicon-info-sign"></i> Información</a></li>
              <li<?php if ( $_GET['tab'] == 'publicaciones' ): ?> class="active"<?php endif; ?>><a href="/Perfil.php?tab=publicaciones"><i class="glyphicon glyphicon-bed"></i> Publicaciones</a></li>
              <li<?php if ( $_GET['tab'] == 'reservas' ): ?> class="active"<?php endif; ?>><a href="/Perfil.php?tab=reservas"><i class="glyphicon glyphicon-lamp"></i> Reservas</a></li>
              <li<?php if ( $_GET['tab'] == 'favoritos' ): ?> class="active"<?php endif; ?>><a href="/Perfil.php?tab=favoritos"><i class="glyphicon glyphicon-heart"></i> Favoritos</a></li>
              <li<?php if ( $_GET['tab'] == 'valoraciones' ): ?> class="active"<?php endif; ?>><a href="/Perfil.php?tab=valoraciones"><i class="glyphicon glyphicon-star"></i> Valoraciones</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-8 col-lg-9"><?php
        if ($ismyprofile){
          if ( !isset($_GET['tab']) ){
            include 'includes/form_profile.php';
            
          }elseif( $_GET['tab'] == 'publicaciones' ){
            include 'includes/publicaciones.php';

          }elseif( $_GET['tab'] == 'reservas' ){
            include 'includes/mis_reservas.php';

          }elseif( $_GET['tab'] == 'valoraciones' ){
            include 'includes/valoraciones.php';

          }elseif( $_GET['tab'] == 'favoritos' ){
            include 'includes/mis_favoritos.php';
          }
        }else{
          include 'includes/basic_info.php';
        } ?>
      </div>
    </div>
  </div>
<?php
$javascripts = <<<EOD
<script type="text/javascript">
$(document).ready(function(){
  $('textarea').elastic();
});
</script>
EOD;
include 'includes/footer.php'; ?>