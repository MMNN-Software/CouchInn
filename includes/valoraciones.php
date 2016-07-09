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

?>
<div class="panel panel-default">
  <div class="panel-body">
    <h5>Valoraciones</h5>
    <hr>
  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#recibidas">Recibidas</a></li>
    <li><a data-toggle="tab" href="#dadas">Dadas</a></li>
  </ul>

  <div class="tab-content">
    <div id="recibidas" class="tab-pane fade in active">
      <h5>Recibidas</h5>
	  <?php include 'includes/valoraciones_recibidas.php'; ?>
    </div>
    <div id="dadas" class="tab-pane fade">
      <h5>Dadas</h5>
      <?php include 'includes/valoraciones_dadas.php'; ?>
    </div>
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