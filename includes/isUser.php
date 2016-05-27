<?php 
  if( !isset($_SESSION['usuario']) ){
    header("Location: /?login&next=".urlencode($_SERVER['REQUEST_URI']));
    die;
  }

 ?>