<?php 
session_start();
error_reporting(E_ALL & ~(E_STRICT|E_NOTICE));
$conexion = new mysqli('localhost','couchinn','FZxMQCESvfwDPyQC','couchinn');
$conexion->set_charset("utf8");

?>