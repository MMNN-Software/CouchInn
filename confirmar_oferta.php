<?php
include 'includes/conexion.php';
include 'includes/header.php';

$hoy = date("Y-m-d");
$idpubli = $_GET['idp'];
$mensaje = $_POST['mensaje'];
$entrada = $_POST['datein'];
$salida = $_POST['dateout'];
$iduser = $_GET['idu'];
$entrada = $hoy;
$salida= $hoy;



$sql = "INSERT INTO reserva (usuario_id, publicacion_id, mensaje, fecha, desde, hasta) VALUES ($iduser, $idpubli, '$mensaje', $hoy, $entrada, $salida )"; 

$mjs = '<div class="alert alert-success">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  Se envio tu petición al dueño de la publicación.
</div>';
echo "$mjs";

header( "refresh:1; url=publicacion.php?id=$idpubli" );


?>