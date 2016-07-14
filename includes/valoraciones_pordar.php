<?php

$publi = $conexion->query("SELECT * FROM publicacion WHERE id IN (SELECT publicacion_id FROM reserva WHERE estado = 2 AND usuario_id = '{$_SESSION['id']}' AND CURDATE() > hasta AND id NOT IN (SELECT reserva_id FROM valoracion where origen_usuario_id = '{$_SESSION['id']}'))");

$user = $conexion->query("SELECT * FROM usuario where id IN 
						(SELECT usuario_id FROM reserva where estado = 2 AND CURDATE() > hasta AND publicacion_id IN 
						(SELECT id from publicacion where usuario_id = '{$_SESSION['id']}') AND id NOT IN (SELECT reserva_id FROM valoracion where origen_usuario_id = '{$_SESSION['id']}'))");
 
$hoy = date("Y-m-d");
?>

<div class="list-group">
<?php while ($pub = $publi->fetch_assoc()) { ?>
  <div class="list-group-item clearfix">
    <span class="pull-left"><?php 
      $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$pub['id']}' LIMIT 1"); 
        if($imagenes->num_rows){
          $im = $imagenes->fetch_assoc();?>
            <img src="/img/publicacion/<?php echo $im['path']; ?>" style="width:150px;margin-right:10px" >
        <?php }else{ ?>
          <img src="/img/logo-pub.png"  style="width:150px;margin-right:10px">
        <?php } 
        $imagenes->free(); ?></span>
		<span class="pull-right">
      <?php include 'val_usuario.php';?>		
      <h4><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#valor_hospedaje" >Valorar</button></h4>   
    </span>		
    <h4 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $pub['id'] ?>"><?php echo $pub['titulo']; ?></a></h4>
        <!--<p class="list-group-item-text"><span class="glyphicon glyphicon-comment"></span> </p>-->
  </div>
<?php } ?>
</div>
 
<div class="list-group">
  <?php while ( $use = $user->fetch_assoc() ) { ?>

  <div class="list-group-item clearfix">
   <span class="pull-left"><?php $imuser = $conexion->query("SELECT foto FROM usuario WHERE id = '{$use['id']}' "); 
    if($imuser->num_rows){
      $im = $imuser->fetch_assoc();?>
        <img src="/img/perfiles/<?php echo $im['foto']; ?>" style="width:150px;margin-right:10px" >
    <?php }else{ ?>
      <img src="/img/logo-pub.png"  style="width:150px;margin-right:10px">
    <?php } 
    $imuser->free(); ?></span>
    <span class="pull-right">
      <?php include 'confirmar_valoracion.php';?>		
    
       <h4><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#valor_usuario" >Valorar</button></h4>
           
    </span>		
    <h4 class="list-group-item-heading"><a href="/Perfil.php?id=<?php echo $use['id'] ?>"><?php echo $use['nombre']; ?></a></h4>
    <!--<p class="list-group-item-text"><span class="glyphicon glyphicon-comment"></span> </p>-->
  </div>
  <?php } ?>
</div>