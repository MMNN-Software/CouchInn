<?php 


  include 'isUser.php';


  if( !$_SESSION['is_admin'] ){
    header("Location: /?login&next=".urlencode($_SERVER["REQUEST_URI"]));
    die;
  }
?>