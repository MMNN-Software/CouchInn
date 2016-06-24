<?php
  include 'includes/conexion.php';

  include 'includes/isUser.php';
  include 'includes/header.php';


  $id = $conexion->real_escape_string($_GET['id']);
  $publicaciones = $conexion->query("SELECT * FROM publicacion WHERE id = '{$id}'");

  if(!$publicaciones->num_rows){
    header("Location: /");
    die;
  }

  $publicacion = $publicaciones->fetch_assoc();



  if(isset($_GET['borrar'])){
    /*// Borro todas las fotos de la publicacion
    $conexion->query("DELETE FROM imagenes WHERE publicacion_id = '{$id}'");

    // Busco si tiene preguntas
    $preguntas = $conexion->query("SELECT * FROM pregunta WHERE publicacion_id = '{$id}'");
    while( $pregunta = $preguntas->fetch_assoc() ){
      //Borro la respuesta
      if($pregunta['respuesta_id'])
        $conexion->query("DELETE FROM respuesta WHERE id = '{$pregunta['respuesta_id']}'");
      //Borro la pregunta
      $conexion->query("DELETE FROM pregunta WHERE id = '{$pregunta['id']}'");
    }

    // Busco si tiene reservas
    $reservas = $conexion->query("SELECT * FROM reserva WHERE publicacion_id = '{$id}'");
    while( $reserva = $reservas->fetch_assoc() ){
      //Busco si tiene valoraciones
      $valoraciones = $conexion->query("SELECT * FROM valoracion WHERE publicacion_id = '{$id}'");
      while( $reserva = $reservas->fetch_assoc() ){
      //Borro la respuesta
      if($pregunta['respuesta_id'])
        $conexion->query("DELETE FROM respuesta WHERE id = '{$pregunta['respuesta_id']}'");
      //Borro la pregunta
      $conexion->query("DELETE FROM pregunta WHERE id = '{$pregunta['id']}'");
    }*/
    //Me di cuenta que estaba haciendo todo esto al pedo, y hay que hacer un borrado lógico. lpmqlp

    $conexion->query("UPDATE publicacion SET estado = 0 WHERE id = '{$id}'");
    header("Location: /Perfil.php?tab=publicaciones");
    die;
  }



?>
<br>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-warning">
          <div class="panel-body">
            ¿Está seguro que desa borrar la publicación "<i><?php echo $publicacion['titulo'] ?></i>"?
          </div>
          <div class="panel-footer clearfix">
            <a href="#" class="btn btn-default" onclick="history.back(); return false;">Cancelar</a>
            <a href="/Borrar.php?id=<?php echo $publicacion['id'] ?>&amp;borrar=<?php echo $publicacion['id'] ?>" class="btn btn-danger">SI, borrar publicación</a>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php include 'includes/footer.php'; ?>