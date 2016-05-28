<?php
  include 'includes/conexion.php';

  include 'includes/isUser.php';
  
  if(isset($_FILES['profile_picture'])){
    $archivo = $_FILES['profile_picture'];
    $nombre = md5($_SESSION['id']).'.jpg';
    $imgSrc = 'img/perfiles/'.$nombre;
    move_uploaded_file($archivo['tmp_name'], $imgSrc);
    switch ($archivo['type']) {

      case 'image/jpg':
        $myImage = imagecreatefromjpeg($imgSrc);
        break;

      case 'image/jpeg':
        $myImage = imagecreatefromjpeg($imgSrc);
        break;

      case 'image/gif':
        $myImage = imagecreatefromgif($imgSrc);
        break;

      case 'image/png':
        $myImage = imagecreatefrompng($imgSrc);
        break;
      
      default:
        $error = "Tipo de archivo no soportado.";
        break;
    }

    if(empty($error)){
      list($width, $height) = getimagesize($imgSrc);

      $myImage = imagecreatefromjpeg($imgSrc);

      // calculating the part of the image to use for thumbnail
      if ($width > $height) {
        $y = 0;
        $x = ($width - $height) / 2;
        $smallestSide = $height;
      } else {
        $x = 0;
        $y = ($height - $width) / 2;
        $smallestSide = $width;
      }

      // copying the part into thumbnail
      $thumbSize = 480;
      $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
      imagecopyresampled($thumb, $myImage, 0, 0, $x, $y, $thumbSize, $thumbSize, $smallestSide, $smallestSide);
      imagejpeg($thumb,$imgSrc,90);
      $conexion->query("UPDATE usuario SET foto = '{$nombre}' WHERE id = '{$_SESSION['id']}';");
      header("Location: /Perfil.php");
      die;
    }else{
      unlink($imgsrc);
    }
  }

  $usuario = $conexion->query("SELECT * FROM usuario WHERE id = '{$_SESSION['id']}'");
  $usuario = $usuario->fetch_assoc();

  include 'includes/header.php'; ?>

<div class="modal fade" id="mejorarCuenta">
  <form action="/Perfil.php" method="POST" class="form" role="form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Mejorar Cuenta</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text"  name="categoria" class="form-control" placeholder="Tarjeta de crédito" required autofocus autocomplete="off">
          </div>
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
              Usuario base
            </div>
          </div>

          <div class="profile-userbuttons">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#mejorarCuenta">Mejorar cuenta</button>
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
        <div class="panel panel-success">
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