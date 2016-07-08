<?php
  $favoritos = $conexion->query("SELECT p.id, f.fecha, p.titulo
                                      FROM favorito f
                                      INNER JOIN publicacion p ON p.id = f.publicacion_id 
                                      WHERE f.usuario_id = '{$_SESSION['id']}'
                                      ORDER BY f.fecha DESC");
?>
<div class="panel panel-default">
  <div class="panel-body">
    <h5>Mis favoritos</h5>
    <hr>
    <div class="list-group">
<?php while( $favorito = $favoritos->fetch_assoc() ){ ?>
      <div class="list-group-item clearfix">
        <span class="pull-left"><?php $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$favorito['id']}' ORDER BY orden ASC LIMIT 1"); 
        if($imagenes->num_rows){
          $im = $imagenes->fetch_assoc();?>
            <img src="/img/publicacion/<?php echo $im['path']; ?>" style="height:50px;margin-right:10px" >
        <?php }else{ ?>
          <img src="/img/logo-pub.png"  style="width:20px;margin-right:10px">
        <?php } 
        $imagenes->free(); ?></span>
        <span class="pull-right">
          <!--aca irian botones-->
        </span>
        <h5 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $favorito['id'] ?>"><?php echo $favorito['titulo']; ?></a></h5>
        <p class="list-group-item-text">Agregado el <?php echo (new Datetime($favorito['fecha']))->format('d-m-Y'); ?></p>
      </div>
<?php } if(!$favoritos->num_rows):?>
  <p class="text-center">No se han encontrado publicaciones.</p>
<?php endif ?>
    </div>
  </div>
</div>