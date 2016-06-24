<div class="panel panel-default">
  <div class="panel-body">
    <h5>Valoraciones</h5>
    <hr>
  </div>
  
  
 <?php
include 'includes/conexion.php';
include 'includes/header.php';
$iduser = $_SESSION['id'];


$publi = $conexion->query("SELECT * FROM publicacion where id IN (SELECT publicacion_id FROM reserva WHERE estado = 2 AND usuario_id = $iduser AND hasta > CURDATE())");
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
          <?php include 'includes/confirmar_valoracion.php';?>		
        
           <h4><button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#valorar" >Valorar</button></h4>
               
        </span>		
        <h4 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $pub['id'] ?>"><?php echo $pub['titulo']; ?></a></h4>
        <!--<p class="list-group-item-text"><span class="glyphicon glyphicon-comment"></span> </p>-->
      </div>
    </div>
	
 <?php 
 }
 
 }
 ?> 

</div>
