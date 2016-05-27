<?php 


  $con = new mysqli('localhost','root','1234','couchinn');
  $ciudades = $con->query("SELECT c.nombre as nombre, p.id as id 
FROM ciudad c 
INNER JOIN provincia p ON p.id = c.provincia_id 
GROUP BY c.nombre,p.id 
HAVING COUNT(*) > 1");

  while ($ciudad = $ciudades->fetch_assoc()) {
    $c = $con->real_escape_string($ciudad['nombre']);
    $con->query("DELETE FROM ciudad WHERE nombre = '{$c}' AND provincia_id = '{$ciudad['id']}' ;");
    $con->query("INSERT INTO ciudad(id, nombre, provincia_id) VALUES (NULL,'{$c}','{$ciudad['id']}');");
    echo $ciudad['nombre']."\n";
  }
 ?>