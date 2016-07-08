<?php

$count = $conexion->query("SELECT COUNT(DISTINCT usuario_id) as personas, COUNT(DISTINCT publicacion_id) as publicaciones FROM reserva r WHERE r.estado = 2 AND DATE(r.fecha) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."'");

$count = $count->fetch_assoc();


if ($reservas->num_rows): ?>

<div class="row">
<div class="col-sm-4">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5>Personas</h5>
			<hr>
			<div style="font-size:48px" class="text-right">
				<?php echo $count['personas'] ?> persona<?php if ($count['personas']!=1) echo 's'; ?>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-4">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5>Reservas</h5>
			<hr>
			<div style="font-size:48px" class="text-right">
				<?php echo $reservas->num_rows ?> reserva<?php if ($pagos->num_rows!=1) echo 's'; ?>
			</div>
		</div>
	</div>
</div>
<div class="col-sm-4">
	<div class="panel panel-default">
		<div class="panel-body">
			<h5>Publicaciones</h5>
			<hr>
			<div style="font-size:48px" class="text-right">
				<?php echo $count['publicaciones'] ?> pub<?php if ($count['publicaciones']!=1) echo 's'; ?>
			</div>
		</div>
	</div>
</div>
</div>

<h5>Detalles</h5>
<hr>
<table class="table table-striped table-hover">
	<thead>
		<tr>
			<th>Nombre</th>
			<th>Publicación</th>
			<th>Fecha de reserva</th>
			<th>Estadía</th>
		</tr>
	</thead>
	<tbody>
	<?php while( $reserva = $reservas->fetch_assoc() ): ?>
		<tr>
			<td><a href="/Perfil.php?id=<?php echo $reserva['usuario_id']?>"><img class="img-circle shadow" src="/img/perfiles/<?php echo ($reserva['foto'])?$reserva['foto']:'default.png'; ?>" width="24"> <?php echo $reserva['nombre']; ?></a></td>
			<td><a href="/Publicacion.php?id=<?php echo $reserva['publicacion_id'] ?>"><?php echo $reserva['titulo']; ?></a></td>
			<td><?php echo $reserva['fecha']; ?></td>
			<td><?php

			    $r_desde = DateTime::createFromFormat("Y-m-d H:i:s",$reserva['desde']);
			    $r_hasta = DateTime::createFromFormat("Y-m-d H:i:s",$reserva['hasta']);
			    $r_dias = ($r_hasta->diff($r_desde,true))->format('%a');
				echo $r_desde->format(DATE_FORMAT);?> - <?php echo $r_hasta->format(DATE_FORMAT) ?> (<?php echo $r_dias ?> día<?php if($r_dias!=1) echo 's'; ?>)</td>
		</tr>
	<?php endwhile; ?>
	</tbody>
</table>

<?php else: ?>

	<div class="alert alert-warning">
		No se han realizado reservas en el lapso indicado. Intenta ampliar el rango.
	</div>

<?php endif ?>