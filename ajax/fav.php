<?php


include '../includes/conexion.php';
include '../includes/isUser.php';

$r = $conexion->query("SELECT * FROM favorito WHERE usuario_id = '{$_SESSION['id']}' AND publicacion_id = '{$_GET['id']}'");
if($r->num_rows){
	$resp = array('estado'=>false);
}else{
	$fecha = date("Y-m-d");
	$conexion->query("INSERT INTO favorito ( id, usuario_id, publicacion_id, fecha) VALUES (NULL,'{$_SESSION['id']}', '{$_GET['id']}', '{$fecha}')");
	$count = $conexion->query("SELECT COUNT(*) as count FROM favorito WHERE publicacion_id = '{$_GET['id']}'");
	$count = $count->fetch_assoc();
	$count = $count['count'];
	$resp = array('estado'=>true,'count'=>$count);
}

header('Content-type: application/json');
echo json_encode($resp);