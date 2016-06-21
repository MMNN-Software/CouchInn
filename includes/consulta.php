<?php
$categoria = $_GET ['categorias'];
if ($categoria == null) {
		$categoria = 2;
}
$titulo = 'complejo';

$publicaciones = $conexion->query("SELECT pu.id, pu.titulo, pu.capacidad, pu.descripcion, pu.fecha, ci.nombre as ciudad, pr.nombre as provincia, pu.ciudad_id, ca.nombre as categoria
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE ca.activa 
ORDER BY pu.fecha DESC
/*LIMIT 8*/");
?>