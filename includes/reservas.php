<?php 
$reservas = $conexion->query("SELECT u.id AS res_user_id,
                                   	u.nombre AS res_u_nombre,
                                   	u.foto,
                                    r.id AS reserva_id,
                                    r.desde AS r_desde,
                                    r.hasta as r_hasta,
                                    r.mensaje AS r_mensaje,
                                    r.estado,
                                    UNIX_TIMESTAMP(r.fecha) AS r_fecha,
                                    p.id AS publicacion_id,
                                    p.titulo AS publicacion_titulo,
                                    p.usuario_id AS publicacion_owner_id
                                FROM reserva r
                                INNER JOIN publicacion p ON p.id = r.publicacion_id
                                INNER JOIN usuario u ON u.id = r.usuario_id
                                WHERE r.estado = 1 OR r.estado = 2 AND r.hasta > CURDATE() AND p.id = '{$id}'
                                ORDER BY r_fecha DESC;");

if (!$reservas->num_rows): ?>
  Por el momento no hay reservas para esta publicación.
<?php else:
	$i = 0;
	while( $reserva = $reservas->fetch_assoc() ): ?>
	  <div class="media">
	    <div class="media-left">
	      <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($reserva['foto'])?$reserva['foto']:'default.png'; ?>" width="48">
	    </div>
	    <div class="media-body">
	      <h5 class="media-heading">
	      	<small class="pull-right"><?php echo tiempo_transcurrido($reserva['r_fecha']) ?></small>
	      	<a href="/Perfil.php?id=<?php echo $reserva['res_user_id']?>"><?php echo $reserva['res_u_nombre'] ?></a>
	      </h5>
		    <form method="post" name="responder_<?php echo ($reserva['reserva_id']) ?>" action="/Publicacion.php?id=<?php echo $publicacion['id'] ?>" class="form" role="form">
		      <!-- <input type="hidden" id="acep_rech" name="aceptar" value="<?php echo ($reserva['reserva_id']) ?>" /> -->
		      <span style="width:70%"><b>Periodo: </b><?php echo $reserva['r_desde'] ?> - <?php echo $reserva['r_hasta'] ?></span> </br>
		      <span style="width:70%"><b>Mensaje: </b><?php echo $reserva['r_mensaje'] ?></span>
		      <div class="pull-right">
		      <?php if ($reserva['estado']==1): ?>
		      <button type="submit" class="btn btn-success btn-sm" name="aceptar" value="<?php echo ($reserva['reserva_id']) ?>">Aceptar</button>
		      <button type="submit" class="btn btn-danger btn-sm" name="rechazar" value="<?php echo ($reserva['reserva_id']) ?>">Rechazar</button>
			  <?php else: ?>
			  	Aceptada
		      <?php endif ?>
		      </div>
		    </form>
	    </div>
	  </div>
	  <hr>
	<?php endwhile ?>
<?php endif ?>

    