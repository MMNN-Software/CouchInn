<?php 
include '../includes/conexion.php';

  function generarLinkTemporal($idusuario, $username){
    global $conexion;
		$cadena = $idusuario.$username.rand(1,9999999).date('Y-m-d');
		$token = sha1($cadena);
    $ex = $conexion->query("SELECT id FROM resetpass WHERE usuario_id = $idusuario;");
    if($ex->num_rows){
		  $conexion->query("UPDATE resetpass SET token = '$token', creado = NOW()");
    }else{
      $conexion->query("INSERT INTO resetpass (usuario_id, token, creado) VALUES($idusuario,'$token',NOW());");
    }
		$enlace = 'http://'.$_SERVER["SERVER_NAME"].'/Restablecer.php?idusuario='.sha1($idusuario).'&token='.$token;
		return $enlace;
	}

	$email = $_POST['email'];
	$respuesta = new stdClass();

	if( $email != "" ){ 

   		$sql = " SELECT * FROM usuario WHERE email = '$email' ";
   		$resultado = $conexion->query($sql);

   		if($resultado->num_rows > 0){
      		$usuario = $resultado->fetch_assoc();
	        $linkTemporal = generarLinkTemporal( $usuario['id'], $usuario['email'] );
      		if($linkTemporal){
        		$respuesta->mensaje = '<div class="alert alert-info"> Un correo ha sido enviado a su cuenta de email con las instrucciones para restablecer la contraseña <br>(<a href="'.$linkTemporal .'">link trucho</a>)</div>';
      		}
   		}
   		else
   			$respuesta->mensaje = '<div class="alert alert-warning"> No existe una cuenta asociada a ese correo. </div>';
	}
	else
   		$respuesta->mensaje= "Debes introducir el email de la cuenta";
 	echo json_encode( $respuesta );