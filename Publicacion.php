<?php
  include 'includes/conexion.php';
  include 'includes/header.php';


  $id = $conexion->real_escape_string($_GET['id']);
  $publicaciones = $conexion->query("SELECT 
    pu.id,
    pu.titulo,
    pu.capacidad,
    pu.descripcion,
    pu.fecha,
    pu.ciudad_id,
    pu.usuario_id,
    pu.categoria_id,
    ci.nombre as ciudad,
    pr.nombre as provincia,
    ca.nombre as categoria,
    u.nombre as owner,
    u.sexo,
    u.foto
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN usuario u ON u.id = pu.usuario_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE pu.id = '{$id}' AND ca.activa ");


if($publicaciones->num_rows){
  $publicacion = $publicaciones->fetch_assoc();
  $img = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$publicacion['id']}' ORDER BY orden ASC");
  $imagenes = array();
  while( $im = $img->fetch_assoc() ){
    $imagenes[] = $im;
  }
  $img->free();
}


?>
  <div class="container main">
  <?php if (!$publicacion): ?>
    Publicacion no encontrada
  <?php else: ?>
    <div class="col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="pull-right">
            <?php if (isset($_SESSION['usuario'])): ?>
              <a href="#" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-heart"></span><span class="hidden-xs"> a favoritos</span></a>
              <?php if ($_SESSION['id'] == $publicacion['usuario_id'] ): ?>
                <a href="#" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                <a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Borrar</a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <a href="#" class="btn btn-sm btn-primary" onclick="history.back();return false;"><span class="glyphicon glyphicon-menu-left"></span> Volver al listado</a>
        </div>
        <div class="publicacion-header">
          <h4><a href="#" class="btn btn-sm btn-success pull-right">Ofertar</a><?php echo $publicacion['titulo']?></h4>
        </div>
        <div class="panel-body">
          <p><a href="/?categoria=<?php echo $publicacion['categoria_id'] ?>"><?php echo $publicacion['categoria'] ?></a> en <a href="/?ciudad=<?php echo $publicacion['ciudad_id'] ?>"><?php echo $publicacion['ciudad'] ?>, <?php echo $publicacion['provincia'] ?></a> para <a href="/?capacidad=<?php echo $publicacion['capacidad'] ?>"><?php echo $publicacion['capacidad'] ?> persona<?php if ($publicacion['capacidad']!=1): ?>s<?php endif ?></a></p>
          <div class="clearfix">
            <?php
            $i = 0;
            foreach ($imagenes as $img): ?>
              <div class="<?php if (!$i++): ?>col-xs-12 col-sm-8 col-md-6<?php else: ?>col-xs-6 col-sm-4 col-md-3<?php endif; ?>">
                <a class="thumbnail" href="/img/publicacion/<?php echo $img['path'] ?>" data-toggle="lightbox" data-gallery="publicacion" data-title="<?php echo htmlentities($publicacion['titulo'], ENT_QUOTES); ?>">
                  <img class="img-responsive" src="/img/publicacion/<?php echo $img['path'] ?>">
                </a>
              </div>
            <?php endforeach ?>
          </div>
          <hr>
          <p><?php echo $publicacion['descripcion'] ?></p>
        </div>
      </div>
      <div class="panel panel-default">
        <div class="panel-body">
          <h5>Preguntas</h5>
          
          <hr>

          <div class="media">
            <div class="media-left">
              <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="48">
            </div>
            <div class="media-body">
              <h5 class="media-heading"><small class="pull-right">Hace 5 horas</small><a href="/Perfil.php?id=<?php echo $publicacion['usuario_id']?>"><?php echo $publicacion['owner'] ?></a></h5>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.

              <div class="media">
                <div class="media-body">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                </div>
                <div class="media-right">
                  <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="48">
                </div>
              </div>
            </div>
          </div>

          <hr>

          <div class="media">
            <div class="media-left">
              <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="48">
            </div>
            <div class="media-body">
              <h5 class="media-heading"><small class="pull-right">Hace 12 horas</small><a href="/Perfil.php?id=<?php echo $publicacion['usuario_id']?>"><?php echo $publicacion['owner'] ?></a></h5>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
              tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.

              <div class="media">
                <div class="media-body">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                  tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
                </div>
                <div class="media-right">
                  <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="48">
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default" id="docked">
        <div class="panel-body">
          <h5>Anfitri<?php echo ($publicacion['sexo']=='F')?'ona':'ón'; ?></h5>
          <hr>
          <div class="media">
            <div class="media-left">
              <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="48">
            </div>
            <div class="media-body">
              <h5 class="media-heading"><a href="/Perfil.php?id=<?php echo $publicacion['usuario_id']?>"><?php echo $publicacion['owner'] ?></a></h5>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.
              </p>
            </div>
          </div>
          <hr>
          <?php

            $resumen = $conexion->query("SELECT AVG(v.valor) as promedio, COUNT(*) as total
                                          FROM valoracion v
                                          WHERE v.destino_usuario_id = '{$publicacion['usuario_id']}'");
            $detalle = $conexion->query("SELECT v.valor, COUNT(*) as cant
                                          FROM valoracion v
                                          WHERE v.destino_usuario_id = '{$publicacion['usuario_id']}'
                                          GROUP BY v.valor
                                          ORDER BY v.valor DESC");
            $valoraciones = $conexion->query("SELECT v.valor, u.nombre, u.foto, v.mensaje
                                              FROM valoracion v
                                              INNER JOIN usuario u ON u.id = v.origen_usuario_id
                                              WHERE v.destino_usuario_id = '{$publicacion['usuario_id']}'
                                              ORDER BY v.mensaje DESC, v.fecha DESC
                                              LIMIT 5");

            $resumen = $resumen->fetch_assoc();
            $clases = ['','one','two','three','four','five'];
            for ($i=1; $i <= 5; $i++){
              $detalles[$i]=0;
            }
            while( $val = $detalle->fetch_assoc() ){
              $detalles[intval($val['valor'])] = $val['cant'];
            }
          ?>
          <div class="rating-box">
            <div class="score-container">
              <div class="score"><?php echo number_format($resumen['promedio'],1,',','.')?></div>
              <div class="score-container-star-rating">
                <div class="small-star star-rating-non-editable-container">
                  <div class="current-rating" style="width: <?php echo floor(($resumen['promedio']*100)/5); ?>%;"></div>
                </div>
              </div>
              <div class="reviews-stats">
                <span class="reviewers-small"></span>
                <span class="reviews-num"><?php echo $resumen['total']; ?></span> en total
              </div>
            </div>
            <div class="rating-histogram">
              <?php for ($i=5; $i > 0; $i--): ?>
              <div class="rating-bar-container <?php echo $clases[$i] ?>">
                <span class="bar-label">
                  <span class="star-tiny star-full"></span><?php echo $i ?>
                </span>
                <span class="bar" style="width:<?php echo floor(($detalles[$i]*100)/$resumen['total']) ?>%"></span>
                <span class="bar-number"><?php echo $detalles[$i] ?></span>
              </div>
              <?php endfor; ?>
            </div>
          </div>
        </div>
        <div class="list-group valoraciones">
          <?php while( $val = $valoraciones->fetch_assoc() ): ?>
          <div class="list-group-item">
            <div class="featured-review-star-rating pull-right">
              <div class="tiny-star star-rating-non-editable-container">
                <div class="current-rating" style="width: <?php echo floor(($val['valor']*100)/5) ?>%;"></div>
              </div>
            </div>
            <img src="/img/perfiles/<?php echo ($val['foto'])?$val['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
            <b><?php echo $val['nombre'] ?></b>
            <p class="list-group-item-text"><?php echo $val['mensaje'] ?></p>
          </div>
          <?php endwhile; ?>
          <a href="#" class="list-group-item text-center">
            <b>Ver todas (<?php echo $resumen['total']; ?>)</b>
          </a>
        </div>
      </div>
    </div>
  <?php endif ?>
  </div>
<?php 
$javascripts = <<<EOD
<script type="text/javascript">
$(document).ready(function(){
  $('.publicacion-header').sticky({topSpacing:64});
});
</script>
EOD;
include 'includes/footer.php'; ?>