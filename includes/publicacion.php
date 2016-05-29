<div class="publicacion col-xs-12 col-sm-6 col-md-4 col-lg-3">
  <div class="panel panel-default">
    <a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>"><?php
      if($publicacion['premium']){
        $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$publicacion['id']}' ORDER BY orden ASC LIMIT 1"); 
        if($imagenes->num_rows){
          $im = $imagenes->fetch_assoc();?>
            <img src="/img/publicacion/<?php echo $im['path']; ?>">
        <?php }else{ ?>
          <img src="/img/logo-pub.png">
        <?php } 
        $imagenes->free();
      }else{?>
          <img src="/img/logo-pub.png">

      <?php }
    ?></a>
    <div class="panel-body">
      <h6><b><?php echo $publicacion['titulo'] ?></b></h6>
      <div>
        Para <?php echo $publicacion['capacidad'] ?> persona<?php if ($publicacion['capacidad']!=1): ?>s<?php endif ?> <br>
        <?php echo $publicacion['categoria'] ?> en <a href="/?ciudad=<?php echo $publicacion['ciudad_id'] ?>"><?php echo $publicacion['ciudad'] ?>, <?php echo $publicacion['provincia'] ?></a>
      </div>
      <hr>
      <p class="descripcion"><?php echo $publicacion['descripcion'] ?></p>
    </div>
    <div class="panel-footer clearfix">
      <a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>" class="btn btn-success btn-sm pull-right" role="button">Ver detalles <span class="glyphicon glyphicon-menu-right"></span></a>
      <div class="btn-group">
        <?php 
          $preguntas = $conexion->query("SELECT COUNT(*) as cant FROM pregunta WHERE publicacion_id = '{$publicacion['id']}'");
          $cantpreg = $preguntas->fetch_assoc();
          $preguntas->free();
          if (isset($_SESSION['usuario'])){
            $favoritos = $conexion->query("SELECT COUNT(*) as cant FROM favorito WHERE publicacion_id = '{$publicacion['id']}'");
            $cantfav = $favoritos->fetch_assoc();
            $favoritos->free();
          ?>
          <a href="#" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Agregar a favoritos">
            <span class="glyphicon glyphicon-heart-empty"></span>
            <span class="favs"><?php if($cantfav['cant']) echo $cantfav['cant'] ?></span>
          </a>
        <?php }
        if ($cantpreg['cant']): ?>
          <a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>#Preguntas" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ver preguntas"><span class="glyphicon glyphicon-comment"></span> <?php echo $cantpreg['cant'] ?></a>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>