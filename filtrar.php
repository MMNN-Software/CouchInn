
<?php

include 'includes/conexion.php';
$sql = "SELECT pu.id, pu.titulo, pu.capacidad, pu.descripcion, pu.fecha, ci.nombre as ciudad, pr.nombre as provincia, pu.ciudad_id, ca.nombre as categoria
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE ca.activa and pu.estado ";

$categoria = $_POST['categoria'];
$ciudad = $_POST['ciudad'];
$entrada = $_POST['datein'];
$salida = $_POST['dateout'];
$capacidad = $_POST['capac'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];


if ($categoria <> 0) {
	$sql .= "AND ca.id = $categoria "; 
}
if ($descripcion <> "") {
	$sql .= "AND pu.descripcion like '%$descripcion%' "; 
}


if ($titulo <> "") {
	$sql .= "AND pu.titulo like '%$titulo%' "; 
}

if ($ciudad <> "") {	
	$prov = substr($ciudad, (strpos($ciudad,',')+1));
	$ciu = substr($ciudad, 0, strpos($ciudad, ','));
	$prov = ltrim($prov);
	$prov1 = $conexion->query("SELECT * FROM provincia WHERE nombre like '%$prov%' ");
    $prov1 = $prov1->fetch_assoc();
	$prov1 = $prov1['id'];
	$ciu = ltrim($ciu);
	$sql .= "AND ci.nombre like '%$ciu%' AND pr.id = $prov1 ";
	
	
	
}

if ($capacidad <> 0) {
	$sql .= "AND pu.capacidad = $capacidad "; 
}
if ($entrada <> "") {
	$fentrada = DateTime::createFromFormat('d/m/Y', $entrada)->format('Y-m-d');
	$fsalida = DateTime::createFromFormat('d/m/Y', $salida)->format('Y-m-d');	
	$sql .= "AND pu.id NOT IN (SELECT publicacion_id FROM reserva r WHERE r.estado = 1 AND (r.desde BETWEEN '$fentrada' AND'$fsalida' OR r.hasta BETWEEN '$fentrada' AND'$fsalida' ) )"; 	
}

$sql .= "ORDER BY pu.fecha DESC /*LIMIT 8*/";
$publicaciones = $conexion->query($sql);
?>
<?php if($publicaciones->num_rows == 0): ?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>¡Cuidado!</strong> La busqueda no dio resultados.
</div>
<?php endif ?>
<?php
 include 'includes/index_filtro.php';
 ?>