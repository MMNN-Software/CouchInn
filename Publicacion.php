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
            <a href="#" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-heart"></span><span class="hidden-xs"> a favoritos</span></a>
            <a href="#" class="btn btn-sm btn-success">Ofertar</a><!--
            <a href="#" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
            <a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Borrar</a>-->
          </div>
          <a href="#" class="btn btn-sm btn-primary" onclick="history.back();return false;"><span class="glyphicon glyphicon-menu-left"></span> Volver al listado</a>
        </div>
        <div class="publicacion-header">
          <h4><?php echo $publicacion['titulo']?></h4>
        </div>
        <div class="panel-body">
          <p><a href="/?categoria=<?php echo $publicacion['categoria_id'] ?>"><?php echo $publicacion['categoria'] ?></a> en <a href="/?ciudad=<?php echo $publicacion['ciudad_id'] ?>"><?php echo $publicacion['ciudad'] ?>, <?php echo $publicacion['provincia'] ?></a> para <a href="/?capacidad=<?php echo $publicacion['capacidad'] ?>"><?php echo $publicacion['capacidad'] ?> persona<?php if ($publicacion['capacidad']!=1): ?>s<?php endif ?></a></p>
          <div class="clearfix">
            <?php
            $i = 0;
            foreach ($imagenes as $img): ?>
              <div class="<?php if (!$i++): ?>col-xs-12 col-sm-8 col-md-6<?php else: ?>col-xs-6 col-sm-4 col-md-3<?php endif; ?>">
                <a class="thumbnail" href="/img/publicacion/<?php echo $img['path'] ?>" data-toggle="lightbox" data-gallery="publicacion">
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
          <div class="rating-box">
            <div class="score-container">
              <div class="score" aria-label="Valoración: 4,7 estrellas de cinco">4,7</div>
              <div class="score-container-star-rating">
                <div class="small-star star-rating-non-editable-container" aria-label="Valoración: 4,7 estrellas de cinco">
                  <div class="current-rating" style="width: 93.63018989562988%;"></div>
                </div>
              </div>
              <div class="reviews-stats">
                <span class="reviewers-small"></span>
                <span class="reviews-num">26</span> en total
              </div>
            </div>
            <div class="rating-histogram">
              <div class="rating-bar-container five">
                <span class="bar-label">
                  <span class="star-tiny star-full"></span>5 
                </span>
                <span class="bar" style="width:100%"></span>
                <span class="bar-number">13</span>
              </div>
              <div class="rating-bar-container four">
                <span class="bar-label">
                  <span class="star-tiny star-full"></span>4
                </span>
                <span class="bar" style="width:46%"></span>
                <span class="bar-number">7</span>
              </div>
              <div class="rating-bar-container three">
                <span class="bar-label">
                  <span class="star-tiny star-full"></span>3
                </span>
                <span class="bar" style="width:20%"></span>
                <span class="bar-number">3</span>
              </div>
              <div class="rating-bar-container two">
                <span class="bar-label">
                  <span class="star-tiny star-full"></span>2
                </span>
                <span class="bar" style="width:5%"></span>
                <span class="bar-number">1</span>
              </div>
              <div class="rating-bar-container one">
                <span class="bar-label">
                  <span class="star-tiny star-full"></span>1
                </span>
                <span class="bar" style="width:10%"></span>
                <span class="bar-number">2</span>
              </div>
            </div>
          </div>
        </div>
        <div class="list-group valoraciones">
          <a href="#" class="list-group-item">
            <div class="featured-review-star-rating pull-right">
              <div class="tiny-star star-rating-non-editable-container">
                <div class="current-rating" style="width: 100%;"></div>
              </div>
            </div>
            <img src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
            <b><?php echo $publicacion['owner'] ?></b>
          </a>
          <a href="#" class="list-group-item">
            <div class="featured-review-star-rating pull-right">
              <div class="tiny-star star-rating-non-editable-container">
                <div class="current-rating" style="width: 80%;"></div>
              </div>
            </div>
            <img src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
            <b><?php echo $publicacion['owner'] ?></b>
          </a>
          <a href="#" class="list-group-item">
            <div class="featured-review-star-rating pull-right">
              <div class="tiny-star star-rating-non-editable-container">
                <div class="current-rating" style="width: 60%;"></div>
              </div>
            </div>
            <img src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
            <b><?php echo $publicacion['owner'] ?></b>
          </a>
          <a href="#" class="list-group-item">
            <div class="featured-review-star-rating pull-right">
              <div class="tiny-star star-rating-non-editable-container">
                <div class="current-rating" style="width: 20%;"></div>
              </div>
            </div>
            <img src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
            <b><?php echo $publicacion['owner'] ?></b>
            <p class="list-group-item-text">Excelente estadía</p>
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