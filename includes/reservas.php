	<?php if ($_SESSION[usuario] != NULL && $_SESSION[id] !== $publicacion[owner_id]):  ?>
	  <form method="post" action="/Publicacion.php?id=<?php echo $publicacion['id'] ?>#Preguntas" class="form" role="form">
		<div class="media">
		  <div class="media-left">
			<img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($_SESSION['foto'])?$_SESSION['foto']:'default.png'; ?>" width="48">
		  </div>
		  <div class="media-body">
			<h5 class="media-heading"><a href="/Perfil.php?id=<?php echo $_SESSION['id'];?>"><?php echo $_SESSION['nombre']; ?></a></h5>
			<input type="hidden" name="preguntar" value="1" />
			<textarea class="col-sm-8" style="font-size:100%; width:100%" required name="pregunta1" id="pregunta1" class="form-control" rows="1" placeholder="Escribe aqui tu pregunta..."></textarea>
			<button type="submit" name="ask_button" id="ask_button" class="btn btn-success">Enviar</button>
		  </div>
		</div>
	  </form>
	<?php endif ?>
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
				<h5 class="media-heading"><small class="pull-right"><?php echo tiempo_transcurrido($reser['pre_fecha']) ?></small><a href="/Perfil.php?id=<?php echo $reser['res_u_id']?>"><?php echo $reser['preguntador'] ?></a></h5>
				<span style="width:70%"><?php echo strip_tags ((string)$reser['r_mensaje']) ?></span> <input type="submit" class="btn btn-success btn-sm" name="aceppt_<?php echo ($reser['reserva_id']) ?>" value="Aceptar" /> <input type="submit" class="btn btn-danger btn-sm" name="reject_<?php echo ($reser['reserva_id']) ?>" value="Rechazar" />
			  </div>
          </div>
          <hr>
        <?php endforeach ?>
      <?php endif ?>
