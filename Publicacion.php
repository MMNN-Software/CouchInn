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
    ci.nombre as ciudad,
    pr.nombre as provincia,
    pu.ciudad_id,
    ca.nombre as categoria,
    pu.usuario_id,
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
            <a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-heart"></span> a favoritos</a><!--
            <a href="#" class="btn btn-sm btn-success">Ofertar</a>
            <a href="#" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
            <a href="#" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Borrar</a>-->
          </div>
          <a href="#" class="btn btn-sm btn-primary" onclick="history.back();return false;"><span class="glyphicon glyphicon-menu-left"></span> Volver al listado</a>
        </div>
        <div class="panel-body">

          <h3><?php echo $publicacion['titulo']?></h3>
          <p><?php echo $publicacion['categoria'] ?> en <a href="/?ciudad=<?php echo $publicacion['ciudad_id'] ?>"><?php echo $publicacion['ciudad'] ?>, <?php echo $publicacion['provincia'] ?></a></p>
          <div class="clearfix">
          <?php foreach ($imagenes as $img): ?>
            <div class="col-xs-6 col-sm-4 col-md-3">
              <a class="thumbnail" href="/img/publicacion/<?php echo $img['path'] ?>" data-toggle="lightbox" data-gallery="publicacion">
                <img class="img-responsive" src="/img/publicacion/<?php echo $img['path'] ?>">
              </a>
            </div>
          <?php endforeach ?>
          </div>
          <h5>Descripción</h5>
          <p><?php echo $publicacion['descripcion'] ?></p>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
      <div class="panel panel-default">
        <div class="panel-body">
          <h5>Su dueño</h5>
          <img src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" class="img-circle shadow pull-left" style="width:64px;">
          <b><?php echo $publicacion['owner'] ?></b>
        </div>
      </div>
    </div>
  <?php endif ?>
  </div>
<?php include 'includes/footer.php'; ?>