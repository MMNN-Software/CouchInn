<?php
include 'includes/conexion.php';
include 'includes/header.php';
$iduser = $_SESSION['id'];


$publi = $conexion->query("SELECT id FROM publicacion where NOT IN (SELECT publicacion_id FROM reserva WHERE estado = 2 AND $iduser = $iduser)");

$valorar = $conexion->query("SELECT * FROM reserva WHERE estado = 2 AND $iduser = $iduser");
$hoy = date("Y-m-d");


if ($valorar->num_rows > 0) {
	   $val_res = array();
	   while ( $val = $valorar->fetch_assoc()){
		   if ($val['fecha'] > $hoy){
				$val_res[] = $val;
		   }		   
	   }
   }

foreach ($val_res AS $val): 
?>
<div class="panel panel-default">
  <div class="panel-body">
    <h5>Valorar reservas</h5>
    <hr>
    <div class="list-group">
<?php while( $pub = $publi->fetch_assoc() ){ ?>
      <div class="list-group-item clearfix">
        <span class="pull-left"><?php $imagenes = $conexion->query("SELECT path FROM imagen WHERE publicacion_id = '{$pub['id']}' ORDER BY orden ASC LIMIT 1"); 
        if($imagenes->num_rows){
          $im = $imagenes->fetch_assoc();?>
            <img src="/img/publicacion/<?php echo $im['path']; ?>" style="width:150px;margin-right:10px" >
        <?php }else{ ?>
          <img src="/img/logo-pub.png"  style="width:150px;margin-right:10px">
        <?php } 
        $imagenes->free(); ?></span>
        <h4 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $pub['id'] ?>"><?php echo $pub['titulo']; ?></a></h4>
        <!--<p class="list-group-item-text"><span class="glyphicon glyphicon-comment"></span> </p>-->
      </div>
<?php } if(!$publicaciones->num_rows):?>
  <p class="text-center">No se han encontrado publicaciones.</p>
<?php endif ?>
    </div>
  </div>
</div>

	  <?php
endforeach


?>