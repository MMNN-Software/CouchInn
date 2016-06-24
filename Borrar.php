<?php
  include 'includes/conexion.php';

  include 'includes/isUser.php';
  include 'includes/header.php';?>



<br>
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-warning">
          <div class="panel-body">
            ¿Está seguro que desa borrar la publicación "<i><?php echo $publicacion['nombre'] ?></i>"?
          </div>
          <div class="panel-footer clearfix">
            <a href="/Publicacion.php?id=<?php echo $publicacion['id'] ?>" class="btn btn-default">Cancelar</a>
            <a href="/Borrar.php?borrar=<?php echo $publicacion['id'] ?>" class="btn btn-danger">SI, borrar publicación</a>
          </div>
        </div>
      </div>
    </div>
  </div>


<?php include 'includes/footer.php'; ?>