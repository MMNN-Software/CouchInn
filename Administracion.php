<?php
  include 'includes/conexion.php';

  //Verificacion de usuario logueado y admin
  include 'includes/isAdmin.php';

  include 'includes/header.php';
?>
<style type="text/css">
  .biglink{
    text-align:center;
    font-size:24px;
  }
  .biglink a{
    display: block;
    padding:30px 10px;
  }
</style>
<br>
<div class="container">
  <div class="col-sm-8 col-sm-offset-2">
    <div class="panel panel-default">
      <div class="panel-body">
        <h5>Administración</h5>
        <hr>
        <div class="row">
          <div class="col-sm-6 biglink"><a href="/Categorias.php">Administrar Categorías</a></div>
          <div class="col-sm-6 biglink"><a href="/Estadisticas.php">Ver Estadísticas</a></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>