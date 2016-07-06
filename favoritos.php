<?php
 include 'includes/conexion.php';
$idpubli = $_GET['idp'];
$iduser = $_SESSION['id'];
$hoy = date("Y-m-d");

$r = $conexion->query("SELECT * FROM favorito WHERE usuario_id = $iduser AND publicacion_id = $idpubli"); 

if ($r->num_rows == 0){	
	$result = $conexion->query("INSERT INTO favorito (usuario_id, publicacion_id, fecha) VALUES ($iduser, $idpubli, $hoy)");
 $mjs = '<div class="alert alert-success">
				<a href="publicacion.php?id=$idpubli" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					La publicación se agrego a favoritos.
			</div>';
	echo "$mjs";
header( "refresh:2; url=publicacion.php?id=$idpubli" );	
}
else{
	$mjs = '<div class="alert alert-success">
				<a href="publicacion.php?id=$idpubli" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					La publicación ya se encuentra en favoritos.
			</div>';
	echo "$mjs";
header( "refresh:2; url=publicacion.php?id=$idpubli" );	
	
}
 

 
 
 
 
include 'includes/footer.php'; 
?>