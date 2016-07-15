<?php 

$preguntas = $conexion->query("SELECT pre.id AS preg_id,
 pre.usuario_id AS preguntador_id,
 pre.respuesta_id AS res_id,
 u.foto AS foto,
 u.nombre AS preguntador,
 pre.pregunta AS pregunta,
 UNIX_TIMESTAMP(pre.fecha) AS pre_fecha,
 res.respuesta AS respuesta,
 res.fecha AS res_fecha
 FROM pregunta pre
 LEFT JOIN respuesta res ON res.id = pre.respuesta_id
 LEFT JOIN usuario u ON u.id=pre.usuario_id
 WHERE pre.publicacion_id = '{$id}'
 ORDER BY pre.fecha DESC;");


 if ($_SESSION['usuario'] != NULL && $_SESSION['id'] !== $publicacion['owner_id']):  ?>
 <form method="post" action="/Publicacion.php?id=<?php echo $publicacion['id'] ?>" class="form form-horizontal" role="form">
  <input type="hidden" name="preguntar" value="1" />
  <div class="form-group">
    <label for="textarea" class="col-sm-1 control-label"><span class="glyphicon glyphicon-comment"></span></label>
    <div class="col-sm-11">
      <textarea name="pregunta" id="textarea" class="form-control" rows="2" required="required" placeholder="Escribe aqui tu pregunta..."></textarea>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-11 col-sm-offset-1">
      <button type="submit" name="ask_button" class="btn btn-primary">Preguntar</button>
    </div>
  </div>
</form>
<hr>
<?php endif ?>

<?php if (!$preguntas->num_rows): ?>
  Por el momento no hay preguntas para esta publicación.
<?php else: ?>
  <?php 
  $i = 0;
  while ( $pregunta = $preguntas->fetch_assoc() ): ?>
  <div class="media">
    <div class="media-left">
      <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($pregunta['foto'])?$pregunta['foto']:'default.png'; ?>" width="48">
    </div>
    <div class="media-body">
      <h5 class="media-heading"><small class="pull-right"><?php echo tiempo_transcurrido($pregunta['pre_fecha']) ?></small><a href="/Perfil.php?id=<?php echo $pregunta['preguntador_id']?>"><?php echo $pregunta['preguntador'] ?></a></h5>
      <span style="width:100%"><?php echo strip_tags ((string)$pregunta['pregunta']) ?></span>
      <?php if ($pregunta['respuesta'] !== NULL): ?>
        <div class="developer-reply" style="width:100%; margin:7px; float:right">
          <div class="media-body" style="background:#e5e5e5; text-align:right">
            <span><?php echo strip_tags ((string)$pregunta['respuesta']) ?></span>
            <div class="box-arrow-up"></div>
          </div>
          <div class="media-right">
            <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="32">
          </div>
        </div>
      <?php endif ?>
      <?php if ($pregunta['respuesta'] == NULL && $_SESSION[id] == $publicacion[owner_id]): ?>
        <form method="post" name="responder_<?php echo ($pregunta['preg_id']) ?>" action="/Publicacion.php?id=<?php echo $publicacion['id'] ?>" class="form" role="form">
          <div class="developer-reply" style="width:100%; margin:7px; float:right">
            <div class="media-body">
              <input type="hidden" name="responder" value="<?php echo ($pregunta['preg_id']) ?>" />
              <textarea style="width:80%; background:#e5e5e5; font-color:black" rows="1" name="respuesta" placeholder="Escribe aqui la respuesta..." required id="preg_<?php echo ($pregunta['preg_id']) ?>"></textarea>
              <input type="submit" class="btn btn-success" name="<?php echo ($pregunta['preg_id']) ?>" value="Responder" />
              <div class="box-arrow-up"></div>
            </div>
            <div class="media-right">
              <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="32">
            </div>
          </div>
        </form>
      <?php endif ?>
    </div>
  </div>
  <hr>
<?php endwhile ?>
<?php endif ?>
