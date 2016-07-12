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
    u.foto
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN usuario u ON u.id = pu.usuario_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE pu.id = '{$id}' AND ca.activa AND pu.estado");

if($publicaciones->num_rows){
  $publicacion = $publicaciones->fetch_assoc();
  $img = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$publicacion['id']}' ORDER BY orden ASC");
  $imagenes = array();
  while( $im = $img->fetch_assoc() ){
    $imagenes[] = $im;
  }
  $img->free();
}

function ask_question ( $publi_id, $user_id, $pregunta) {
  $error = 0;
    global $conexion;
    if( empty(strip_tags ($pregunta))) $error |= PREGUNTA_EMPTY;

    if($error) return $error;

    $publi_id = $conexion->real_escape_string($publi_id);
    $user_id = $conexion->real_escape_string($user_id);
    $pregunta = $conexion->real_escape_string(strip_tags ($pregunta));
    $tiempo = date("Y-m-d H:i:s");
  $conexion->query("INSERT INTO pregunta (publicacion_id, usuario_id, pregunta, fecha) VALUES ({$publi_id}, {$user_id}, '{$pregunta}', '{$tiempo}');");
  return 0;
}

if( isset($_POST['preguntar']) ){
  $error = ask_question(
      $publicacion['id'],
      $_SESSION['id'],
      $_POST['pregunta1']);
  $pre_agregada = 1;
  $mensaje = "Pregunta guardada exitosamente.";
  }
else {
    $pre_agregada = 0;
}

function reply_question ( $preg_id, $user_id, $respuesta) {
  $error = 0;
    global $conexion;
    if( empty(strip_tags ($respuesta))) $error |= RESPUESTA_EMPTY;

    if($error) return $error;

    $preg_id = $conexion->real_escape_string($preg_id);
    $user_id = $conexion->real_escape_string($user_id);
    $respuesta = $conexion->real_escape_string(strip_tags ($respuesta));
    $tiempo = date("Y-m-d H:i:s");
  $conexion->query("INSERT INTO respuesta (id, respuesta, fecha) VALUES (NULL, '{$respuesta}', '{$tiempo}');");
  $conexion->query("UPDATE pregunta SET respuesta_id='{$conexion->insert_id}' WHERE id='{$preg_id}';");
  return 0;
}

function aceptar_reserva ( $reserva_id, $user_id) {
    $error = 0;
  global $conexion;
  if($error) return $error;
  
    $reserva_id = $conexion->real_escape_string($reserva_id);
    $user_id = $conexion->real_escape_string($user_id);
  // CANCELADO 0 - PENDIENTE 1 - ACEPTADO 2 - Rechazado 3
  $conexion->query("UPDATE reserva SET estado=2, fecha_aceptacion=current_date WHERE id={$reserva_id};");
  $a_rechazar = $conexion->query("SELECT GROUP_CONCAT(r.id) as reserva_id FROM reserva r
                    INNER JOIN reserva r2 ON r2.publicacion_id=r.publicacion_id
                    WHERE (((r.desde BETWEEN r2.desde AND r2.hasta)
                     OR (r.hasta BETWEEN r2.desde AND r2.hasta))
                                         OR ((r2.desde BETWEEN r.desde AND r.hasta)
                     OR (r2.hasta BETWEEN r.desde AND r.hasta)))
                    AND r2.id != r.id AND r2.id= {$reserva_id};");
  if ($a_rechazar->num_rows) {
    $a_rech = $a_rechazar->fetch_assoc();
  }
  $sql = "UPDATE reserva SET estado=3 WHERE id IN ({$a_rech[reserva_id]});";
  if ($conexion->query($sql) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error updating record: " . $conexion->error;
  }
  return 0;
}

function rechazar_reserva ( $reserva_id, $user_id) {
  $error = 0;
  global $conexion;
  if($error) return $error;
  
    $reserva_id = $conexion->real_escape_string($reserva_id);
    $user_id = $conexion->real_escape_string($user_id);
  // CANCELADO 0 - PENDIENTE 1 - ACEPTADO 2 - RECHAZADO 3
  $conexion->query("UPDATE reserva SET estado=3 WHERE id={$reserva_id};");
  return 0;
}

if( isset($_POST['responder']) ){
  $error = reply_question(
      $_POST['responder'],
      $_SESSION['id'],
      $_POST['respuesta']);
  $res_agregada = 1;
  $mensaje = "Respuesta guardada exitosamente.";
  }
else {
    $res_agregada = 0;
}

if( isset($_POST['aceptar']) ){
  $error = aceptar_reserva(
      $_POST['aceptar'],
      $_SESSION['id']);
  $reserva_aceptada = 1;
  $mensaje = "Reserva aceptada correctamente.";
  }
else {
    $reserva_aceptada = 0;
}

if( isset($_POST['rechazar']) ){
  $error = rechazar_reserva(
      $_POST['rechazar'],
      $_SESSION['id']);
  $reserva_rechazada = 1;
  $mensaje = "Reserva rechazada correctamente.";
  }
else {
    $reserva_rechazada = 0;
}

$favoritos = $conexion->query("SELECT COUNT(*) as cant, COUNT(usuario_id = '{$_SESSION['id']}') as isfav FROM favorito WHERE publicacion_id = '{$id}'");
$favoritos = $favoritos->fetch_assoc();
?>
  <?php include 'includes/ofertar.php';?>  
  <style type="text/css">.oculta{display:none}</style>  
  <div class="container main">
  <?php if (!$publicacion): ?>
    Publicacion no encontrada
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
          <h5 id="Preguntas">Preguntas</h5>
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
                                              WHERE r.publicacion_id = '{$publicacion['id']}'
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

<?php if ($pre_agregada == 1): ?>
<script type="text/javascript">
  $(function(){successAlert('Exito', 'La pregunta fue guardada exitosamente.');
        });
</script>
<?php endif ?>
<?php if ($res_agregada == 1): ?>
<script type="text/javascript">
  $(function(){successAlert('Exito', 'La respuesta fue guardada exitosamente.');
        });
</script>
<?php endif ?>
<?php if ($reserva_aceptada == 1): ?>
<script type="text/javascript">
  $(function(){successAlert('Exito', 'La reserva fue aceptada exitosamente.');
        });
</script>
<?php endif ?>
<?php if ($reserva_rechazada == 1): ?>
<script type="text/javascript">
  $(function(){successAlert('Exito', 'La reserva fue rechazada exitosamente.');
        });
</script>
<?php endif ?>
<script type="text/javascript">
function handleClick()
{
    this.value = (this.value == '+' ? '-' : '+');
}
document.getElementById('res_icon').onclick=handleClick;
</script>