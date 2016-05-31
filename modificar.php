<?php 
include 'includes/conexion.php';
include 'includes/header.php';

$name = $_POST['nombre'];
$dni = $_POST['dni'];
$religion = $_POST['religion'];
$biografia = $_POST['biografia'];
$domicilio = $_POST['domicilio']; 
$id = $conexion->query("SELECT id FROM usuario WHERE id = '{$_SESSION['id']}'");
$sexo = $_POST['sexo']; 


?>

    <div class="container" role="main">
      <div class="col-md-2"></div>
      <div class="col-md-8">
<?php
	
	$sql = "SELECT * FROM usuario WHERE id = $id ";
	$resultado = $conexion->query($sql);
	if( $resultado->num_rows > 0 ){
		$usuario = $resultado->fetch_assoc();
		if(  $usuario['email'] === $email  ){
			
				$sql = " UPDATE usuario SET nombre = '$name' dni = '$dni' religion = '$religion' sexo = '$sexo'  WHERE email = '$email' ";
				$resultado = $conexion->query($sql);
				if($resultado){
?>
					<p> El Perfil se actualizó con exito. </p>
				<?php
				}
				else{
				?>
					<p> Ocurrió un error al actualizar el perfil, intentalo más tarde </p>
				<?php
				}
				
		}
	}
include 'includes/footer.php';		
?>