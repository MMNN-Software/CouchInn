<?php
include 'includes/conexion.php';
include 'includes/header.php';

$hoy = date("Y-m-d");
$mensaje = $_POST['mensaje'];
$valor = $_POST['valoracion'];
$iduser = $_SESSION['id'];
$to = $_GET['idp'];
$idpubli = $_POST['idpubli'];

$res = $conexion->query("SELECT id FROM reserva WHERE usuario_id = $iduser AND publicacion_id = $idpubli");
$reserva = $res->fetch_assoc();

$sql = "INSERT INTO valoracion (reserva_id, origen_usuario_id, destino_usuario_id, fecha,valor, mensaje) VALUES ('{$reserva['id']}', $iduser, $to, '$hoy', $valor, '$mensaje')"; 


if ($conexion->query($sql) === TRUE) {
	$conexion->query("UPDATE reserva SET estado = 5 WHERE usuario_id = $iduser AND publicacion_id = $idpubli");
    $mjs = '<div class="alert alert-success">
				<a href="publicacion.php?id=$idpubli" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Se envio tu valoracion al hospedaje.
			</div>';
	echo "$mjs";
header( "refresh:2; url=Publicacion.php?id=$idpubli" );
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}








?>