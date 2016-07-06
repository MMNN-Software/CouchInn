<?php
include 'includes/conexion.php';
include 'includes/header.php';

$hoy = date("Y-m-d");
$mensaje = $_POST['mensaje'];
$valor = $_POST['valoracion'];
$iduser = $_SESSION['id'];
$to = $_GET['idu'];
$idp = $conexion->query("SELECT id FROM reserva WHERE usuario_id = $to AND estado = 2 AND publicacion_id IN (SELECT id FROM publicacion WHERE usuario_id = $iduser)");
if ($idp->num_rows > 0) {
 $pub = $idp->fetch_assoc();
}

/*$res = $conexion->query("SELECT id FROM reserva WHERE usuario_id = $to AND publicacion_id = '{$pub['id']}'");
if ($res->num_rows > 0) {
$reserva = $res->fetch_assoc();
}*/
$sql = "INSERT INTO valoracion (reserva_id, origen_usuario_id, destino_usuario_id, fecha,valor, mensaje) VALUES ({$pub['id']}, $iduser, $to, '$hoy', $valor, '$mensaje')"; 


if ($conexion->query($sql) === TRUE) {
	/*$conexion->query("UPDATE reserva SET estado = 5 WHERE usuario_id = $iduser AND publicacion_id = $idpubli");*/
    $mjs = '<div class="alert alert-success">
				<a href="Perfil.php?tab=valoraciones" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Se envio tu valoracion al hospedaje.
			</div>';
	echo "$mjs";
header( "refresh:2; url=Perfil.php?tab=valoraciones" );
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

?>