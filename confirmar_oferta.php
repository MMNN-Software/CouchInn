<?php
include 'includes/conexion.php';


$iduser = $conexion->real_escape_string((isset($_GET['id']))?$_GET['id']:$_SESSION['id']);
$mensaje = $_POST['mensaje'];
$entrada = $_POST['datein'];
$salida = $_POST['dateout'];

$sql = "INSERT INTO reserva (usuario_id, publicacion_id, mensaje, fecha, desde, hasta, estado) VALUES ($iduser, $idpubli, $mensaje, GETDATE(), $entrada, $salida, 0 )"; 


?>