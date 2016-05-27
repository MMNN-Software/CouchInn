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

  include 'includes/header.php';

?>
  <div class="container main">
    <div class="row">
      <div class="col-sm-4">
        <div class="panel panel-success">
          <dir class="panel-body">
            <div class="profile-picture">
              <img src="/img/perfiles/<?php echo ($usuario['foto'])?$usuario['foto']:'default.png'; ?>" class="img-circle">
            </div>
            <h4><?php echo $usuario['nombre'] ?></h4>
            <p><?php echo $usuario['email'] ?></p>
            <form action="/Perfil.php" method="POST" enctype="multipart/form-data" id="changeProfilePicture">
              <span class="btn btn-success btn-block btn-file">Cambiar mi foto de perfil <input type="file" name="profile_picture"></span>
            </form>
          </dir>
        </div>
      </div>
      <div class="col-sm-8">
        <div class="panel panel-success">
          <div class="panel-body">
            <?php var_dump($usuario); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php include 'includes/footer.php'; ?>