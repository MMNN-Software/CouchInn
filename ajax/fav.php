<?php

include '../includes/conexion.php';
include '../includes/isUser.php';

header('Content-type: application/json');

if(!preg_match('/^[0-9]+$/',$_GET['id'])){
	echo json_encode(array('estado'=>false));
}

$idprop = $conexion->real_escape_string($_GET['id']);

$publicacion = $conexion->query("SELECT * FROM publicacion WHERE id = '{$idprop}'");
$r = $conexion->query("SELECT * FROM favorito WHERE usuario_id = '{$_SESSION['id']}' AND publicacion_id = '{$idprop}'");
if(!$publicacion->num_rows or $r->num_rows){
	$resp = array('estado'=>false);
}else{
	$fecha = date("Y-m-d H:i:s");
	$conexion->query("INSERT INTO favorito ( id, usuario_id, publicacion_id, fecha) VALUES (NULL,'{$_SESSION['id']}', '{$idprop}', '{$fecha}')");
	$count = $conexion->query("SELECT COUNT(*) as count FROM favorito WHERE publicacion_id = '{$idprop}'");
	$count = $count->fetch_assoc();
	$count = $count['count'];
	$resp = array('estado'=>true,'count'=>$count);
}

echo json_encode($resp);