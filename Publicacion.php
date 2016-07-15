<?php
  include 'includes/conexion.php';
  include 'includes/header.php';
  include 'includes/functions.php';

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
    u.id as owner_id,
    u.nombre as owner,
    u.biografia as biografia,
    u.sexo,
    u.foto,
    ca.activa
    FROM publicacion pu
    INNER JOIN categoria ca ON ca.id = pu.categoria_id
    INNER JOIN usuario u ON u.id = pu.usuario_id
    INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
    INNER JOIN provincia pr ON pr.id = ci.provincia_id
    WHERE pu.id = '{$id}' AND pu.estado");

  if($publicaciones->num_rows){
    $publicacion = $publicaciones->fetch_assoc();
    $img = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$publicacion['id']}' ORDER BY orden ASC");
    $imagenes = array();
    while( $im = $img->fetch_assoc() ){
      $imagenes[] = $im;
    }
    $img->free();
  }

  if( isset($_POST['preguntar']) ){
    $fecha = date("Y-m-d H:i:s");
    $pregunta = $conexion->real_escape_string($_POST['pregunta']);
    $conexion->query("INSERT INTO pregunta (publicacion_id, usuario_id, pregunta, fecha) 
      VALUES ('{$publicacion['id']}', '{$_SESSION['id']}', '{$pregunta}', '{$fecha}');");
    $mensaje = "Pregunta enviada.";
  }

  if( isset($_POST['responder']) ){
    $respuesta = $conexion->real_escape_string($_POST['respuesta']);
    $fecha = date("Y-m-d H:i:s");
    $conexion->query("INSERT INTO respuesta (id, respuesta, fecha) VALUES (NULL, '{$respuesta}', '{$fecha}');");
    $conexion->query("UPDATE pregunta SET respuesta_id = '{$conexion->insert_id}' WHERE id='{$_POST['responder']}';");
    $mensaje = "Respuesta guardada exitosamente.";
  }

  if( isset($_POST['aceptar']) ){
    //TODO: revisar que la reserva que se acepta sea válida por las fechas
    $conexion->query("UPDATE reserva SET estado = 2, fecha_aceptacion = current_date WHERE id = '{$_POST['aceptar']}';");
    $conexion->query("UPDATE reserva SET estado = 3 WHERE id IN (
                      SELECT GROUP_CONCAT(r.id) as reserva_id FROM reserva r
                      INNER JOIN reserva r2 ON r2.publicacion_id = r.publicacion_id
                      WHERE (((r.desde BETWEEN r2.desde AND r2.hasta) OR (r.hasta BETWEEN r2.desde AND r2.hasta))
                        OR ((r2.desde BETWEEN r.desde AND r.hasta) OR (r2.hasta BETWEEN r.desde AND r.hasta)))
                      AND r2.id != r.id AND r2.id = {$reserva_id});");
    $mensaje = "Reserva aceptada correctamente.";
  }

  if( isset($_POST['rechazar']) ){
    // CANCELADO 0 - PENDIENTE 1 - ACEPTADO 2 - RECHAZADO 3
    $conexion->query("UPDATE reserva SET estado = 3 WHERE id = '{$_POST['rechazar']}';");
    $mensaje = "Reserva rechazada correctamente.";
  }

  if( isset($_POST['ofertar']) ){
    $fecha = date("Y-m-d H:i:s");
    $mensaje1 = $conexion->real_escape_string($_POST['mensaje']);
    $in = DateTime::createFromFormat('d/m/Y', $_POST['datein'])->format('Y-m-d');
    $out = DateTime::createFromFormat('d/m/Y', $_POST['dateout'])->format('Y-m-d');

    $valoraciones = $conexion->query("SELECT * FROM reserva 
      WHERE publicacion_id = '{$_GET['id']}' AND usuario_id = '{$_SESSION['id']}' AND
      '{$in}' BETWEEN desde AND hasta OR desde BETWEEN '{$in}' AND '{$out}' AND estado = 2");

    if ($valoraciones->num_rows) {
      $error = "Ya existe una oferta que interfiere con tu oferta actual";
    }else{
      $conexion->query("INSERT INTO reserva (usuario_id, publicacion_id, mensaje, fecha, desde, hasta, estado) 
        VALUES ('{$_SESSION['id']}', '{$_GET['id']}', '{$mensaje1}', '{$fecha}', '{$in}', '{$out}', 1)");
      $mensaje = "Se envió tu petición al dueño de la publicación.";
    }
  }

  if(!$publicacion['activa'])
    $error .= "La categoria de la publicación se encuentra inactiva, podrás ver la publicación pero no aparecerá en los listados.<br>Para que vuelva a aparecer podés editarla con una categoria nueva.";

  $favoritos = $conexion->query("SELECT COUNT(*) as cant, COUNT(usuario_id = '{$_SESSION['id']}') as isfav FROM favorito WHERE publicacion_id = '{$id}'");
  $favoritos = $favoritos->fetch_assoc();
?>
  <?php include 'includes/form_ofertar.php';?>  
  <style type="text/css">.oculta{display:none}</style>  
  <div class="container main">

  <?php if (!empty($error)): ?>
    <div class="alert alert-dismissible alert-danger">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php echo $error ?>
    </div>
  <?php endif ?>
  <?php if (!empty($mensaje)): ?>
    <div class="alert alert-dismissible alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <?php echo $mensaje ?>
    </div>
  <?php endif ?>

  <?php if (!$publicacion): ?>
    <div class="alert alert-danger">
      Publicacion no encontrada
    </div>
  <?php else: ?>
    <div class="col-sm-8">
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="pull-right">
            <?php if (isset($_SESSION['usuario'])): ?>
              <a href="#" data-fav="<?php echo $publicacion['id'] ?>" class="btn btn-sm btn-<?php echo ($favoritos['isfav'])?'danger':'default'; ?>" data-toggle="tooltip" data-placement="top" title="Agregar a favoritos">
                <span class="glyphicon glyphicon-heart"></span>
                <span class="favs"><?php if($favoritos['cant']) echo $favoritos['cant'] ?></span>
              </a>
              <?php if ($_SESSION['id'] == $publicacion['usuario_id'] ): ?>
                <a href="/Agregar.php?editar=<?php echo $publicacion['id']?>" class="btn btn-sm btn-warning"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                <a href="/Borrar.php?id=<?php echo $publicacion['id']?>" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Borrar</a>
              <?php endif; ?>
            <?php endif; ?>
          </div>
          <a href="#" class="btn btn-sm btn-primary" onclick="history.back();return false;"><span class="glyphicon glyphicon-menu-left"></span> Volver al listado</a>
        </div>
  
        <div class="publicacion-header">
           <h4>

            <?php if (isset($_SESSION['usuario']) and  $_SESSION['id'] != $publicacion['usuario_id'] ): ?>
              <button type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#ofertar" >Ofertar</button>
            <?php endif ?>
            <?php echo $publicacion['titulo']?>
            </h4>
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

<?php if ( isset($_SESSION['usuario']) and  $_SESSION['id'] == $publicacion['usuario_id'] ): ?>
      <div class="panel panel-default">
        <div class="panel-body">
          <h5>Reservas</h5>
          <hr>
          <?php include 'includes/reservas.php' ?>
        </div>
      </div>
<?php endif?>
    
      <div class="panel panel-default">
        <div class="panel-body">
          <h5>Preguntas</h5>
          <hr>
          <?php include 'includes/preguntas.php' ?>
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
              <p><?php echo $publicacion['biografia'] ?></p>
            </div>
          </div>
          <hr>
          <?php include('includes/resumen_valoracion.php'); ?>
        </div>
       <div class="list-group valoraciones">
          <?php 
            $valoraciones = $conexion->query("SELECT v.valor, u.nombre, u.foto, v.mensaje
                                              FROM valoracion v
                                              INNER JOIN reserva r ON r.id=v.reserva_id
                                              INNER JOIN usuario u ON u.id = v.origen_usuario_id
                                              WHERE r.publicacion_id = '{$publicacion['id']}' AND v.destino_usuario_id = '{$publicacion['owner_id']}'
                                              ORDER BY v.mensaje DESC, v.fecha DESC");
            $i = 0;
            while( $val = $valoraciones->fetch_assoc() ): ?>

              <div class="list-group-item<?php if ($i>=5): ?> oculta<?php endif ?>">
                <div class="featured-review-star-rating pull-right">
                  <div class="tiny-star star-rating-non-editable-container">
                    <div class="current-rating" style="width: <?php echo floor(($val['valor']*100)/5) ?>%;"></div>
                  </div>
                </div>
                <img src="/img/perfiles/<?php echo ($val['foto'])?$val['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
                <b><?php echo $val['nombre'] ?></b>
                <p class="list-group-item-text"><?php echo $val['mensaje'] ?></p>
              </div>
              <?php if ($i == 4 && $valoraciones->num_rows > 5){ ?>
                <a href="#" class="list-group-item text-center" onclick="$('.oculta').show();$(this).hide();return false;">
                  <b>Ver más (<?php echo $valoraciones->num_rows - 5; ?>)</b>
                </a>
              <?php }
              $i++; ?>

          <?php endwhile; ?>
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
  $('textarea').elastic();
});
</script>
EOD;
include 'includes/footer.php'; ?>