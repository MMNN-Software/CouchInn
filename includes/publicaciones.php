<?php

$publicaciones = $conexion->query("SELECT * FROM publicacion WHERE usuario_id = '{$usuario_perfil['id']}'");
?>
<div class="panel panel-default">
  <div class="panel-body">
    <h5>Mis publicaciones</h5>
    <hr>
    <div class="list-group">
<?php while( $publicacion = $publicaciones->fetch_assoc() ){ ?>
      <a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>" class="list-group-item clearfix">
        <span class="pull-left"><?php $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$publicacion['id']}' ORDER BY orden ASC LIMIT 1"); 
        if($imagenes->num_rows){
          $im = $imagenes->fetch_assoc();?>
            <img src="/img/publicacion/<?php echo $im['path']; ?>" style="width:200px;margin-right:10px" >
        <?php }else{ ?>
          <img src="/img/logo-pub.png"  style="width:200px;margin-right:10px">
        <?php } 
        $imagenes->free(); ?></span>
        <span class="pull-right">
          <button class="btn btn-sm btn-warning">
            <span class="glyphicon glyphicon-pencil"></span> Editar
          </button>
          <button class="btn btn-sm btn-danger">
            <span class="glyphicon glyphicon-trash"></span> Borrar
          </button>
        </span>
        <h3 class="list-group-item-heading"><?php echo $publicacion['titulo']; ?></h3>
        <p class="list-group-item-text"><?php echo $publicacion['descripcion']; ?></p>
      </a>
<?php } ?>
    </div>
  </div>
</div>