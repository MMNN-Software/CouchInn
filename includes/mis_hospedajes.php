<?php

$iduser = $_SESSION['id'];
$publicaciones = $conexion->query("SELECT * FROM publicacion where id IN (SELECT publicacion_id FROM reserva WHERE (estado = 2 OR estado = 5) AND usuario_id = $iduser)");
?>
<div class="panel panel-default">
  <div class="panel-body">
    <h5>Mis hospedajes</h5>
    <hr>
    <div class="list-group">
<?php while( $publicacion = $publicaciones->fetch_assoc() ){ ?>
      <div class="list-group-item clearfix">
        <span class="pull-left"><?php $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$publicacion['id']}' ORDER BY orden ASC LIMIT 1"); 
        if($imagenes->num_rows){
          $im = $imagenes->fetch_assoc();?>
            <img src="/img/publicacion/<?php echo $im['path']; ?>" style="width:150px;margin-right:10px" >
        <?php }else{ ?>
          <img src="/img/logo-pub.png"  style="width:150px;margin-right:10px">
        <?php } 
        $imagenes->free(); ?></span>
        <span class="pull-right">
          <!--aca irian botones-->
        </span>
        <h4 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>"><?php echo $publicacion['titulo']; ?></a></h4>
        <!--<p class="list-group-item-text"><span class="glyphicon glyphicon-comment"></span> </p>-->
      </div>
<?php } if(!$publicaciones->num_rows):?>
  <p class="text-center">No se han encontrado publicaciones.</p>
<?php endif ?>
    </div>
  </div>
</div>