      <?php if (!isset($_res)): ?>
        Por el momento no hay reservas para esta publicacion.
      <?php else: ?>
        <?php 
        $i = 0;
        foreach ($_res AS $reser): ?>
          <div class="media">
			  <div class="media-left">
				<img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($reser['foto'])?$reser['foto']:'default.png'; ?>" width="48">
			  </div>
			  <div class="media-body">
				<h5 class="media-heading"><a href="/Perfil.php?id=<?php echo $reser['res_u_id']?>"><?php echo $reser['res_u_nombre'] ?></a></h5>
				<form method="post" name="responder_<?php echo ($reser['reserva_id']) ?>" action="/Publicacion.php?id=<?php echo $publicacion['id'] ?>#Reservas" class="form" role="form">
					<input type="hidden" name="aceptar" value="<?php echo ($reser['reserva_id']) ?>" />
					<span style="width:70%"><?php echo strip_tags ((string)$reser['r_mensaje']) ?></span> <input type="submit" class="btn btn-success btn-sm" name="aceppt_<?php echo ($reser['reserva_id']) ?>" value="Aceptar" /> <input type="submit" class="btn btn-danger btn-sm" name="reject_<?php echo ($reser['reserva_id']) ?>" value="Rechazar" />
				</form>
			  </div>
          </div>
          <hr>
        <?php endforeach ?>
      <?php endif ?>

	  