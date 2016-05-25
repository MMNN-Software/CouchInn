<?php 
  if( !isset($_SESSION['usuario']) || !$_SESSION['is_admin'] ){
    header("Location: /Ingresar.php?from=".urlencode($_SERVER["REQUEST_URI"])."&reason=admin");
    die;
  }
?>