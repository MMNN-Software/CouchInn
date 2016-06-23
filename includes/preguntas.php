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




      <?php if (!isset($preg_res)): ?>
        Por el momento no hay preguntas para esta publicacion.
      <?php else: ?>
        <?php 
        $i = 0;
        foreach ($preg_res AS $prre): ?>
          <div class="media">
          <div class="media-left">
            <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($prre['foto'])?$prre['foto']:'default.png'; ?>" width="48">
          </div>
          <div class="media-body">
            <h5 class="media-heading"><small class="pull-right"><?php echo tiempo_transcurrido($prre['pre_fecha']) ?></small><a href="/Perfil.php?id=<?php echo $prre['preguntador_id']?>"><?php echo $prre['preguntador'] ?></a></h5>
            <span style="width:100%"><?php echo strip_tags ((string)$prre['pregunta']) ?></span>
            <?php if ($prre['respuesta'] !== NULL): ?>
              <div class="developer-reply" style="width:100%; margin:7px; float:right">
              <div class="media-body" style="background:#e5e5e5; text-align:right">
                <span><?php echo strip_tags ((string)$prre['respuesta']) ?></span>
                <div class="box-arrow-up"></div>
              </div>
              <div class="media-right">
                <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="32">
              </div>
              </div>
            <?php endif ?>
            <?php if ($prre['respuesta'] == NULL && $_SESSION[id] == $publicacion[owner_id]): ?>
            <form method="post" name="responder_<?php echo ($prre['preg_id']) ?>" action="/Publicacion.php?id=<?php echo $publicacion['id'] ?>#Preguntas" class="form" role="form">
              <div class="developer-reply" style="width:100%; margin:7px; float:right">
              <div class="media-body">
                <input type="hidden" name="responder" value="<?php echo ($prre['preg_id']) ?>" />
                <textarea style="width:80%; background:#e5e5e5; font-color:black" rows="1" name="respuesta" placeholder="Escribe aqui la respuesta..." required id="preg_<?php echo ($prre['preg_id']) ?>"></textarea>
                <input type="submit" class="btn btn-success" name="<?php echo ($prre['preg_id']) ?>" value="Responder" />
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
        <?php endforeach ?>
      <?php endif ?>
