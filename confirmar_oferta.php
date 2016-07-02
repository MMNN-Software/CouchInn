<?php
include 'includes/conexion.php';
include 'includes/header.php';

$hoy = date("Y-m-d");
$idpubli = $_GET['idp'];
$mensaje = $_POST['mensaje'];
$entrada = $_POST['datein'];
$salida = $_POST['dateout'];
$iduser = $_SESSION['id'];
$entrada = $_GET['datein'];
$salida= $_GET['dateout'];



$sql = "INSERT INTO reserva (usuario_id, publicacion_id, mensaje, fecha, desde, hasta, estado) VALUES ($iduser, $idpubli, '$mensaje', '$hoy', '$entrada', '$salida', 1 )"; 

$result = $conexion->query("select * from reserva where publicacion_id = $idpubli AND usuario_id = $iduser");

if ($result->num_rows == 0) {
	if ($conexion->query($sql) === TRUE) {
    $mjs = '<div class="alert alert-success">
				<a href="publicacion.php?id=$idpubli" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Se envio tu petición al dueño de la publicación.
			</div>';
	echo "$mjs";
header( "refresh:2; url=publicacion.php?id=$idpubli" );
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
	
} else{
	
	$mjs = '<div class="alert alert-danger">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					Usted ya tiene una oferta pendiente en esta publicación.
			</div>';
	echo "$mjs";
header( "refresh:2; url=Publicacion.php?id=$idpubli" );
}








?>