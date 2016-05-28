<?php
  include 'includes/conexion.php';

  include 'includes/isUser.php';


  function luhn_check($number) {
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
    }
  }

  $usuario = $conexion->query("SELECT * FROM usuario WHERE id = '{$_SESSION['id']}'");
  $usuario = $usuario->fetch_assoc();

  include 'includes/header.php'; ?>

<div class="modal fade" id="mejorarCuenta">
  <form action="/Perfil.php" method="POST" class="form" role="form">
    <div class="modal-dialog" style="max-width:400px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Mejorar Cuenta</h4>
        </div>
        <div class="modal-body">
          <form class="form" action="/Perfil.php" method="POST">
            <p>Se te cobrará un costo de membresía por única vez de $150</p>
            <div class="row">
              <div class="col-xs-12">
                <label class="control-label">Número de tarjeta</label>
                <div class="input-group">
                  <input type="text"  name="tarjeta" class="form-control" placeholder="XXXXXXXXXXXXXXXX" minlength="16" maxlength="16" required autofocus autocomplete="off">
                  <span class="input-group-addon"><span class="glyphicon glyphicon-credit-card"></span></span>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label">Fecha de vencimiento</label>
                  <input type="text"  name="expires" class="form-control" placeholder="MM/AA" minlength="5" maxlength="5" required autocomplete="off">
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label">Código de seguridad</label>
                  <input type="text"  name="ccv" class="form-control" placeholder="XXX" required autocomplete="off" minlength="3" maxlength="4">
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Mejorar</button>
        </div>
      </div>
    </div>
  </form>
</div>


<div class="modal fade" id="darDeBaja">
  <form action="/Perfil.php" method="POST" class="form" role="form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Dar de baja</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text"  name="categoria" class="form-control" placeholder="Tarjeta de crédito" required autofocus autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-trash"></span> ELIMINAR MI CUENTA EN COUCHINN Y MIS PUBLICACIONES</button>
        </div>
      </div>
    </div>
  </form>
</div>

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
          <form action="/Perfil.php" method="POST" enctype="multipart/form-data" id="changeProfilePicture">
            <div class="profile-picture img-circle shadow">
              <img src="/img/perfiles/<?php echo ($usuario['foto'])?$usuario['foto']:'default.png'; ?>">
              <span class="mensaje-upload"><span class="glyphicon glyphicon-camera"></span> Subir</span>
              <input type="file" name="profile_picture" accept="image/*">
            </div>
          </form>

          <div class="profile-usertitle">
            <div class="profile-usertitle-name">
              <?php echo $usuario['nombre'] ?>
            </div>
            <div class="profile-usertitle-job">
              <?php if ($usuario['premium']): ?>
                Usuario Premium
              <?php else: ?>
                Usuario Base
              <?php endif ?>
            </div>
          </div>

          <div class="profile-userbuttons">
            <?php if (!$usuario['premium']): ?>
              <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#mejorarCuenta">Mejorar cuenta</button>
            <?php endif; ?>
            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#darDeBaja">Dar de baja</button>
          </div>

          <div class="profile-usermenu">
            <ul class="nav">
              <li class="active">
                <a href="#">
                <i class="glyphicon glyphicon-info-sign"></i>
                Información </a>
              </li>
              <li>
                <a href="#">
                <i class="glyphicon glyphicon-home"></i>
                Mis Publicaciones </a>
              </li>
              <li>
                <a href="#">
                <i class="glyphicon glyphicon-star"></i>
                Valoraciones </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="col-sm-8 col-lg-9">
        <div class="panel panel-primary">
          <div class="panel-heading">Datos personales</div>
          <div class="panel-body">
            <div class="row">
              <div class="col-xs-6 text-right"><b>Correo electrónico:</b></div>
              <div class="col-xs-6"><?php echo $usuario['email'] ?></div>
            </div>
            <div class="row">
              <div class="col-xs-6 text-right"><b>DNI:</b></div>
              <div class="col-xs-6"><?php echo $usuario['dni'] ?></div>
            </div>
            <div class="row">
              <div class="col-xs-6 text-right"><b>Religión:</b></div>
              <div class="col-xs-6"><?php echo $usuario['religion'] ?></div>
            </div>
            <div class="row">
              <div class="col-xs-6 text-right"><b>Domicilio:</b></div>
              <div class="col-xs-6"><?php echo $usuario['domicilio'] ?></div>
            </div>
            <div class="row">
              <div class="col-xs-6 text-right"><b>Sexo:</b></div>
              <div class="col-xs-6"><?php echo $usuario['sexo'] ?></div>
            </div>
          </div>
          <div class="panel-footer text-right">
            <a href="#" class="btn btn-primary">Editar</a>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include 'includes/footer.php'; ?>