<?php

$iduser = $_SESSION['id'];
$reservas = $conexion->query("SELECT u.id AS res_user_id,
	u.nombre AS res_u_nombre,
	u.foto,
	r.id AS reserva_id,
	r.desde AS r_desde,
	r.hasta as r_hasta,
	r.mensaje AS r_mensaje,
	UNIX_TIMESTAMP(r.fecha) AS r_fecha,
	p.id AS publicacion_id,
	p.titulo AS publicacion_titulo,
	p.usuario_id AS publicacion_owner_id,
	CASE WHEN r.estado=0 THEN 'Cancelado'
	WHEN r.estado=1 THEN 'Pendiente'
	WHEN r.estado=2 THEN 'Aprobado'
	WHEN r.estado=3 THEN 'Rechazado'
	END AS 'estado'
	FROM reserva r
	INNER JOIN publicacion p ON p.id = r.publicacion_id
	INNER JOIN usuario u ON u.id = r.usuario_id
	WHERE r.estado = 2 AND r.hasta <= current_date AND r.usuario_id='{$iduser}'
	ORDER BY p.titulo, r_fecha DESC;");
	?>
	<div class="panel panel-default">
		<div class="panel-body">
			<h5>Mis hospedajes</h5>
			<hr>
			<div class="list-group">
				<?php while( $reserva = $reservas->fetch_assoc() ){ ?>
					<div class="list-group-item clearfix">
						<span class="pull-left"><?php $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$reserva['publicacion_id']}' ORDER BY orden ASC LIMIT 1"); 
							if($imagenes->num_rows){
								$im = $imagenes->fetch_assoc();?>
								<img src="/img/publicacion/<?php echo $im['path']; ?>" style="width:150px;margin-right:10px" >
								<?php }else{ ?>
									<img src="/img/logo-pub.png"  style="width:150px;margin-right:10px">
									<?php } 
									$imagenes->free(); ?></span>
									<h4 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $reserva['publicacion_id'] ?>"><?php echo $reserva['publicacion_titulo']; ?></a><small class="pull-right"><?php echo tiempo_transcurrido($reserva['r_fecha']) ?></small></h4>
									<span class="pull-right">
										<!--aca irian botones-->
									</span>
									<span style="width:70%"><b>Periodo: </b><?php echo strip_tags ((string)$reserva['r_desde']) ?> - <?php echo strip_tags ((string)$reserva['r_hasta']) ?></span> </br>
									<span style="width:70%"><b>Mensaje: </b><?php echo strip_tags ((string)$reserva['r_mensaje']) ?></span> </br>
									<span style="width:70%"><b>Estado: </b><?php echo strip_tags ((string)$reserva['estado']) ?></span>
									<!--<p class="list-group-item-text"><span class="glyphicon glyphicon-comment"></span> </p>-->
								</div>
								<?php } if(!$reservas->num_rows):?>
								<p class="text-center">No se han encontrado hospedajes.</p>
							<?php endif ?>
						</div>
					</div>
				</div>