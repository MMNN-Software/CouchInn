<?php

$consultaBusqueda = $_POST['valorBusqueda'];

if (isset($consultaBusqueda)) {

$consulta = $conexion->query("SELECT pu.id, pu.titulo, pu.capacidad, pu.descripcion, pu.fecha, ci.nombre as ciudad, pr.nombre as provincia, pu.ciudad_id, ca.nombre as categoria
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE ca.activa and ci.nombre AND pu.estado LIKE '%$consultaBusqueda%'
ORDER BY pu.fecha DESC
/*LIMIT 8*/");

    while($publicacion = mysqli_fetch_array($consulta)) {
			include 'includes/publicacion.php';

			//Output
			$mensaje .= '
			';

		}

};
?>