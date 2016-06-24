<?php 

  include '../includes/conexion.php';

  $term = $conexion->real_escape_string($_GET['q']);

  
  $ciudades = $conexion->query("SELECT c.id, c.nombre as ciudad, p.nombre as provincia, (SELECT COUNT(*) FROM publicacion pi WHERE pi.ciudad_id = c.id AND pi.estado) as publicaciones
    FROM ciudad c 
    INNER JOIN provincia p ON p.id = c.provincia_id 
    WHERE c.nombre LIKE '%{$term}%'
    ORDER BY publicaciones DESC
    LIMIT 5");




  /*$ciudades = $conexion->query("SELECT c.id, c.nombre as ciudad, p.nombre as provincia
    FROM ciudad c 
    INNER JOIN provincia p ON p.id = c.provincia_id 
    WHERE c.nombre LIKE '%{$term}%' LIMIT 5 ");*/



  /*$ciudades = $conexion->query("SELECT c.id, c.nombre as ciudad, p.nombre as provincia, COUNT(*) as publicaciones
    FROM ciudad c 
    INNER JOIN provincia p ON p.id = c.provincia_id 
    INNER JOIN publicacion pu ON pu.ciudad_id = c.id
    WHERE c.nombre LIKE '%{$term}%'
    GROUP BY c.id, ciudad, provincia
    HAVING COUNT(*) > 0  LIMIT 5");*/

  $datos = array();
  while ( $ciudad = $ciudades->fetch_assoc() ) {
    $ciudad['label'] = $ciudad['ciudad'].', '.$ciudad['provincia'];
    $datos[] = $ciudad;
  }

  header("Content-Type: application/json");
  echo json_encode($datos);
 ?>