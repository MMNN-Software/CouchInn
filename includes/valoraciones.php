<div class="panel panel-default">
  <div class="panel-body">
    <h5>Valoraciones</h5>
    <hr>
    <h6>Dadas</h6>
    <hr>
    <h6>Recibidas</h6>
    <hr>
    <?php

    $resumen = $conexion->query("SELECT AVG(v.valor) as promedio, COUNT(*) as total
                                  FROM valoracion v
                                  WHERE v.destino_usuario_id = '{$_SESSION['id']}'");
    $detalle = $conexion->query("SELECT v.valor, COUNT(*) as cant
                                  FROM valoracion v
                                  WHERE v.destino_usuario_id = '{$_SESSION['id']}'
                                  GROUP BY v.valor
                                  ORDER BY v.valor DESC");
    $resumen = $resumen->fetch_assoc();
    $clases = ['','one','two','three','four','five'];
    for ($i=1; $i <= 5; $i++){
      $detalles[$i]=0;
    }
    while( $val = $detalle->fetch_assoc() ){
      $detalles[intval($val['valor'])] = $val['cant'];
    }

    ?><div class="rating-box row">
      <div class="score-container col-xs-6">
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
      <div class="rating-histogram col-xs-6">
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

    <div class="list-group valoraciones">
      <?php 
        $valoraciones = $conexion->query("SELECT v.valor, u.nombre, u.foto, v.mensaje, p.titulo, p.id as publicacion_id, r.desde, r.hasta
                                          FROM valoracion v
                                          INNER JOIN usuario u ON u.id = v.origen_usuario_id
                                          INNER JOIN reserva r ON r.id = v.reserva_id
                                          INNER JOIN publicacion p ON p.id = r.publicacion_id
                                          WHERE v.destino_usuario_id = '{$_SESSION['id']}'
                                          ORDER BY v.mensaje DESC, v.fecha DESC");
        while( $val = $valoraciones->fetch_assoc() ): ?>
          <div class="list-group-item">
            <div class="featured-review-star-rating pull-right">
              <div class="tiny-star star-rating-non-editable-container">
                <div class="current-rating" style="width: <?php echo floor(($val['valor']*100)/5) ?>%;"></div>
              </div>
            </div>
            <img src="/img/perfiles/<?php echo ($val['foto'])?$val['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
            <b><?php echo $val['nombre'] ?></b>
            en
            <a href="/Publicacion.php?id=<?php echo $val['publicacion_id'] ?>"><?php echo $val['titulo'] ?></a>
            desde el <?php echo (new DateTime($val['desde']))->format('d-m-Y'); ?> hasta el <?php echo (new DateTime($val['hasta']))->format('d-m-Y'); ?>
            <p class="list-group-item-text"><?php echo $val['mensaje'] ?></p>
          </div>
      <?php endwhile; ?>
    </div>
  </div>
  
  
 <?php /*
include 'includes/conexion.php';
include 'includes/header.php';
$iduser = $_SESSION['id'];


$publi = $conexion->query("SELECT * FROM publicacion where id IN (SELECT publicacion_id FROM reserva WHERE estado = 2 AND usuario_id = $iduser AND CURDATE() > hasta AND id NOT IN (SELECT reserva_id FROM VALORACION where origen_usuario_id = $iduser))");
$user = $conexion->query("SELECT * FROM usuario where id IN 
						(SELECT usuario_id FROM reserva where estado = 2 AND CURDATE() > hasta AND publicacion_id IN 
						(SELECT id from publicacion where usuario_id = $iduser) AND id NOT IN (SELECT reserva_id FROM VALORACION where origen_usuario_id = $iduser))");
 
$hoy = date("Y-m-d");

?>
<?php
if ($publi->num_rows > 0) {
	   $val_res = array();
	   while ( $val = $publi->fetch_assoc()){
		   	$val_res[] = $val;  
	   }
	   

 ?>
    <div class="list-group">
<?php foreach ($val_res as $pub) { ?>

      <div class="list-group-item clearfix">
        <span class="pull-left"><?php $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$pub['id']}' ORDER BY orden ASC LIMIT 1"); 
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
    </div>
	
 <?php 
 }
 
 }
 if ($user->num_rows > 0) {
	   $user_res = array();
	   while ( $u = $user->fetch_assoc()){
		   	$user_res[] = $u;  
	   }
 
  ?>
    <div class="list-group">
<?php foreach ($user_res as $use) { ?>

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
          <?php include 'includes/confirmar_valoracion.php';?>		
        
           <h4><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#valor_usuario" >Valorar</button></h4>
               
        </span>		
        <h4 class="list-group-item-heading"><a href="/Perfil.php?id=<?php echo $use['id'] ?>"><?php echo $use['nombre']; ?></a></h4>
        <!--<p class="list-group-item-text"><span class="glyphicon glyphicon-comment"></span> </p>-->
      </div>
    </div>
	
 <?php 
 }
 
 } 
 ?>
</div>
<?php */