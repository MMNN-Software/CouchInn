<?php

$reservas = $conexion->query("SELECT r.id, r.desde, r.mensaje, r.hasta, r.usuario_id, u.nombre, p.titulo, r.publicacion_id
  FROM reserva r
  INNER JOIN publicacion p ON p.id = r.publicacion_id
  INNER JOIN usuario u ON u.id = r.usuario_id
  WHERE r.hasta < CURDATE() AND p.usuario_id = '{$_SESSION['id']}' AND r.estado = 2 AND r.id NOT IN (
    SELECT reserva_id FROM valoracion WHERE reserva_id = r.id AND origen_usuario_id = p.usuario_id AND destino_usuario_id = r.usuario_id
  )");

$publicaciones = $conexion->query("SELECT r.id, r.desde, r.hasta, p.usuario_id, u.foto, u.nombre, p.titulo, r.publicacion_id, (SELECT path FROM imagen WHERE publicacion_id = p.id LIMIT 1) as imagen
  FROM reserva r
  INNER JOIN publicacion p ON p.id = r.publicacion_id
  INNER JOIN usuario u ON u.id = r.usuario_id
  WHERE r.hasta < CURDATE() AND r.usuario_id = '{$_SESSION['id']}' AND r.estado = 2 AND r.id NOT IN (
    SELECT reserva_id FROM valoracion WHERE reserva_id = r.id AND origen_usuario_id = r.usuario_id AND destino_usuario_id = p.usuario_id
  )");
 
$hoy = date("Y-m-d");
?>

<h5>Publicaciones</h5>
<?php if ($publicaciones->num_rows): ?>
<div class="list-group">
<?php while ($reserva = $publicaciones->fetch_assoc()) { ?>
  <div class="list-group-item clearfix">
    <span class="pull-left">
      <img src="/img/<?php echo ($reserva['imagen'])?'publicacion/'.$reserva['imagen']:'logo-pub.png'; ?>" style="width:75px;margin-right:10px" >
    </span>
    <h4 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $reserva['publicacion_id'] ?>"><?php echo $reserva['titulo']; ?></a></h4>
    <p>Estuviste desde el <?php echo $reserva['desde'] ?> hasta el <?php echo $reserva['hasta'] ?></p>
    <p><?php echo $reserva['mensaje'] ?></p>
    <?php include('form_valorar.php'); ?>
  </div>
<?php } ?>
</div>
<?php else: ?>
  <p class="text-center">No hay usuarios que calificar</p>
<?php endif ?>




<h5>Usuarios</h5>
<?php if ($reservas->num_rows): ?>
<div class="list-group">
<?php while ( $reserva = $reservas->fetch_assoc() ) { ?>
  <div class="list-group-item clearfix">
    <span class="pull-left">
      <img src="/img/perfiles/<?php echo ($reserva['foto'])?$reserva['foto']:'default.png'; ?>" style="width:75px;margin-right:10px" >
    </span> 
    <h4 class="list-group-item-heading">
      <a href="/Perfil.php?id=<?php echo $reserva['id'] ?>"><?php echo $reserva['nombre']; ?></a>
    </h4>
    <p>Estuvo desde el <?php echo $reserva['desde'] ?> hasta el <?php echo $reserva['hasta'] ?></p>
    <p>En <a href="/Publicacion.php?id=<?php echo $reserva['publicacion_id'] ?>"><?php echo $reserva['titulo']; ?></a></p>
    <?php include('form_valorar.php'); ?>
  </div>
<?php } ?>
</div>
<?php else: ?>
  <p class="text-center">No hay usuarios que calificar</p>
<?php endif ?>