<?php 
  if( !isset($_SESSION['usuario']) || $_SESSION['privilegios'] != 'admin' ){
    header("Location: /Ingresar.php?from=".urlencode($_SERVER["REQUEST_URI"])."&reason=admin");
    die;
  }
?>