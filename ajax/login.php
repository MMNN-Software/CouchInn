<?php 
  include '../includes/conexion.php';
  include '../includes/functions.php';

  if(isset($_SESSION['usuario'])){
    header("Location: /");
    die;
  }

  function error($num = 0){
    $mensajes = array(
      'Todo piola guachin',
      'Falta indicar correo',
      'Falta indicar correo',
      'Usuario inexistente',
      'Contraseña incorrecta'
    );
    $data = array('estado'=>(boolean)(!$num), 'mensaje'=>$mensajes[$num]);
    header('Content-Type: application/json');
    echo json_encode($data);
    die;
  }

  if( isset($_POST['login']) ){
    
    if( !isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ){
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

    doLoginOf($usuario);

    error(0);

  }
  header("Location: /");
?>