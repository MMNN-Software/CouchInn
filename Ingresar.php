<?php 
  include 'includes/conexion.php';

  function error($num = 0){
    header("Location: /Ingresar.php?error=".$num);
    die;
  }

  if( isset($_POST['login']) ){
    
    if( !isset($_POST['email']) || !preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/", $_POST['email']) ){
      error(1);
    }

    if( !isset($_POST['password']) || empty($_POST['password']) ){
      error(2);
    }

    $email = $conexion->real_escape_string(trim($_POST['email']));
    $usuario = $conexion->query("SELECT * FROM usuario WHERE email = '{$email}'");

    if( !$usuario->num_rows ){
      error(3);
    }

    $usuario = $usuario->fetch_assoc();

    if( md5($_POST['password']) != $usuario['password'] ){
      error(4);
    }

    $_SESSION['id'] = $usuario['id'];
    $_SESSION['usuario'] = $usuario['email'];
    $_SESSION['nombre'] = $usuario['nombre'];
    $_SESSION['is_admin'] = ( $usuario['tipo'] == 'admin' );

    header('Location: /');
    die;

  }

  include 'includes/header.php';
  include 'includes/footer.php';
?>