<div class="publicacion col-xs-12 col-sm-6 col-md-4 col-lg-3">
  <div class="panel panel-default">
    <a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>"><?php
      if($_SESSION['premium']){
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
      <h6>
        <b><?php echo $publicacion['titulo'] ?></b>
      </h6>
      <div>
        <div class="featured-review-star-rating pull-right" data-toggle="tooltip" data-placement="left" title="<?php echo number_format($publicacion['ranking'],1); ?> estrellas">
          <div class="tiny-star star-rating-non-editable-container">
            <div class="current-rating" style="width: <?php echo round(($publicacion['ranking']*100)/5) ?>%;"></div>
          </div>
        </div>
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
            $favoritos = $conexion->query("SELECT COUNT(*) as cant, (SELECT COUNT(*) FROM favorito WHERE usuario_id = '{$_SESSION['id']}' AND publicacion_id = '{$publicacion['id']}') as isfav FROM favorito WHERE publicacion_id = '{$publicacion['id']}'");
            $favoritos = $favoritos->fetch_assoc();
          ?>
          <a href="#" data-fav="<?php echo $publicacion['id'] ?>" class="btn btn-sm btn-<?php echo ($favoritos['isfav'])?'danger':'default'; ?>" data-toggle="tooltip" data-placement="top" title="Agregar a favoritos">
            <span class="glyphicon glyphicon-heart"></span>
            <span class="favs"><?php if($favoritos['cant']) echo $favoritos['cant'] ?></span>
          </a>
        <?php }
        if ($cantpreg['cant']): ?>
          <a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>#Preguntas" class="btn btn-sm btn-default" data-toggle="tooltip" data-placement="top" title="Ver preguntas"><span class="glyphicon glyphicon-comment"></span> <?php echo $cantpreg['cant'] ?></a>
        <?php endif ?>
      </div>
    </div>
  </div>
</div>