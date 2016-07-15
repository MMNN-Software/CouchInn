<?php 
  include 'isUser.php';

  if( !$_SESSION['is_admin'] ){
    header("Location: /");
    die;
  }
?>