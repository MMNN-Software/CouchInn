<?php

  include 'includes/conexion.php';
  include 'includes/functions.php';

  if(isset($_SESSION['usuario'])){
    header("Location: /");
    die;
  }

  define('NOMBRE_EMPTY',  1);
  define('EMAIL_EMPTY',   2);
  define('EMAIL_INVALID', 4);
  define('EMAIL_TAKEN',   8);
  define('PASS_EMPTY',   16);
  define('PASS_EQUAL',   32);
  define('PASS_SHORT',   64);
  define('SEX_EMPTY',   128);
  
  $error = 0;

  function do_register( $email, $nombre, $pass, $repass, $sexo ){
    $error = 0;
    global $conexion;
    if( empty($email) ) $error |= EMAIL_EMPTY;
    if( empty($nombre) ) $error |= NOMBRE_EMPTY;
    if( empty($pass) ) $error |= PASS_EMPTY;
    if( empty($repass) ) $error |= PASS_EQUAL;
    if( empty($sexo) ) $error |= SEX_EMPTY;
    if( $sexo != 'F' && $sexo != 'M' ) $error |= SEX_EMPTY;

    if(!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) $error |= EMAIL_INVALID;
    if(strlen($pass)<6) $error |= PASS_SHORT;
    if($pass != $repass) $error |= PASS_EQUAL;

    $correos = $conexion->query("SELECT id FROM usuario WHERE email = '".$conexion->real_escape_string($email)."'");
    if($correos->num_rows) $error |= EMAIL_TAKEN;
    $correos->free();

    if($error) return $error;

    $email = $conexion->real_escape_string($email);
    $nombre = $conexion->real_escape_string($nombre);
    $pass = md5($pass);
    $fecha = date("Y-m-d H:i:s");
    $conexion->query("INSERT INTO usuario (id, email, nombre, password, sexo, tipo, activo, registro) VALUES (NULL, '{$email}', '{$nombre}','{$pass}', '{$sexo}', 'user', 1, '{$fecha}' )");
    $usuario = $conexion->query("SELECT * FROM usuario WHERE id = '{$conexion->insert_id}'");
    doLoginOf($usuario->fetch_assoc());
    return 0;
  }

  if( isset($_POST['registrarse']) ){
    $error = do_register(
      $_POST['email'],
      $_POST['nombre'],
      $_POST['pass'],
      $_POST['repass'],
      $_POST['sexo']);
    if(!$error){
      header("Location: /?bienvenido");
      die;
    }
  }

  $headerbg = '/img/forest-house.jpg';
  include 'includes/header.php';
?>
<br>
<div class="container">
<div class="row">
<div class="col-xs-12 col-sm-6 col-md-5 col-lg-4">
<form action="/Registrarse.php" method="post" class="form" role="form">
  <div class="panel panel-default animated slideInDown">
    <div class="panel-body">
      <h5>Registrarse</h5>
      <hr>
      <input type="hidden" name="registrarse" value="1">

      <div class="form-group<?php if ($error & NOMBRE_EMPTY) echo ' has-error'; ?>">
        <input type="text"  name="nombre" class="form-control" placeholder="Nombre" required autofocus autocomplete="off" value="<?php echo htmlentities($_POST['nombre'], ENT_QUOTES); ?>">
        <span class="help-block">Será tu nombre público en el sitio</span>
        <?php if ($error & NOMBRE_EMPTY): ?>
          <span class="help-block">El nombre no puede estar vacío</span>
        <?php endif ?>
      </div>

      <div class="form-group<?php if ($error & ( EMAIL_TAKEN | EMAIL_INVALID | EMAIL_EMPTY ) ) echo ' has-error'; ?>">
        <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required autocomplete="off" value="<?php echo htmlentities($_POST['email'], ENT_QUOTES); ?>">
        <?php if ($error & EMAIL_EMPTY): ?>
          <span class="help-block">El correo no puede estar vacío</span>
        <?php endif ?>
        <?php if ($error & EMAIL_INVALID): ?>
          <span class="help-block">El correo parece ser inválido</span>
        <?php endif ?>
        <?php if ($error & EMAIL_TAKEN): ?>
          <span class="help-block">El correo ya se encuentra en uso</span>
        <?php endif ?>
      </div>

      <div class="form-group<?php if ($error & ( PASS_EMPTY | PASS_SHORT ) ) echo ' has-error'; ?>">
        <input type="password" name="pass" class="form-control" placeholder="Tu contraseña" required minlength="6" maxlength="32">
        <span class="help-block">Debe ser entre 6 y 32 caracteres</span>
        <?php if ($error & PASS_SHORT): ?>
          <span class="help-block">La contraseña es demasiado corta</span>
        <?php endif ?>
        <?php if ($error & PASS_EMPTY): ?>
          <span class="help-block">La contraseña no puede estar vacía</span>
        <?php endif ?>
      </div>

      <div class="form-group<?php if ($error & PASS_EQUAL) echo ' has-error'; ?>">
        <input type="password" name="repass" class="form-control" placeholder="Repite tu contraseña" required minlength="6" maxlength="32">
        <?php if ($error & PASS_EQUAL): ?>
          <span class="help-block">Las contraseñas no coinciden</span>
        <?php endif ?>
      </div>

      <div class="form-group<?php if ($error & SEX_EMPTY) echo ' has-error'; ?>">
        <span>Sexo:</span>
        <div class="radio">
          <label>
            <input type="radio" name="sexo" value="F"<?php if ($_POST['sexo']=='F'): ?> checked="checked"<?php endif ?>>
            Mujer
          </label>
        </div>
        <div class="radio">
          <label>
            <input type="radio" name="sexo" value="M"<?php if ($_POST['sexo']=='M'): ?> checked="checked"<?php endif ?>>
            Hombre
          </label>
        </div>
        <?php if ($error & SEX_EMPTY): ?>
          <span class="help-block">Debes indicar tu sexo</span>
        <?php endif ?>
      </div>
    </div>
    <div class="panel-footer text-right">
      <a href="/" class="btn btn-default">Cancelar</a>
      <button type="submit" class="btn btn-success">Registrarme</button>
    </div>
  </div>
</form>
</div>
</div>
</div>
<?php include 'includes/footer.php'; ?>