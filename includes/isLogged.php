<?php 
  if( !isset($_SESSION['usuario']) ){
    header("Location: /?from=".urlencode($_SERVER["REQUEST_URI"])."&reason=user");
    die;
  }
?>