<?php 
  if( !isset($_SESSION['usuario']) ){
    header("Location: /Ingresar.php?from=".urlencode($_SERVER["REQUEST_URI"])."&reason=user");
    die;
  }
?>