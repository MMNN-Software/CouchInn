
<?php

include 'includes/conexion.php';
$sql = "SELECT pu.id,
       pu.titulo,
       pu.capacidad,
       pu.descripcion,
       pu.fecha,
       ci.nombre as ciudad,
       pr.nombre as provincia,
       pu.ciudad_id,
       ca.nombre as categoria,
       COALESCE(val.promedio,0.0) as ranking
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
INNER JOIN (SELECT p.id AS publicacion_id, COALESCE(AVG(v.valor), 0.0) as promedio, COUNT(*) as total
FROM publicacion p
LEFT JOIN reserva r ON r.publicacion_id=p.id
LEFT JOIN valoracion v ON r.id=v.reserva_id
GROUP BY p.id) val ON val.publicacion_id = pu.id
WHERE ca.activa AND pu.estado ";

$orden = $_POST['ordenar'];
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
	$sql .= "AND pu.id NOT IN (SELECT publicacion_id FROM reserva r WHERE r.estado = 2 AND '$fentrada' BETWEEN r.desde AND r.hasta OR '$fsalida' BETWEEN r.desde AND r.hasta AND r.desde BETWEEN '$fentrada' AND'$fsalida' OR r.hasta BETWEEN '$fentrada' AND'$fsalida'  )"; 	
}

if ($orden == 0) {
	$sql .= "ORDER BY pu.fecha DESC /*LIMIT 8*/";
}
if ($orden == 1) {	
	$sql .= "ORDER BY pu.titulo ASC /*LIMIT 8*/";
}
if ($orden == 2) {	
	$sql .= "ORDER BY promedio DESC /*LIMIT 8*/";
}

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