<?php
  include 'includes/conexion.php';

  //Verificacion de usuario logueado y admin
  include 'includes/isAdmin.php';


  if(isset($_GET['addcat'])){
    $categoria = trim($_POST['categoria']);
    if( !empty($categoria) ){
      $categoria = $conexion->real_escape_string($categoria);
      $cat = $conexion->query("SELECT id FROM categoria WHERE nombre = '{$categoria}';");
      if($cat->num_rows){
        $error = "La categoría ya existe.";
      }else{
        $conexion->query("INSERT INTO categoria (id, nombre, activa) VALUES (NULL,'{$categoria}',1);");
      }
      $cat->free();
    }else{
      $error = "La categoría no puede estar vacía.";
    }
  }

  $categorias = $conexion->query("SELECT c.id as id, c.nombre as nombre, COUNT(p.id) as pubs FROM categoria c LEFT JOIN publicacion p ON p.categoria_id = c.id GROUP BY c.id, c.nombre ");

  include 'includes/header.php';
?>
<div class="modal fade" id="addCat">
  <form action="/Administracion.php?addcat" method="POST" class="form" role="form">
    <div class="modal-dialog addcat-modal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Agregar Categoría</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text"  name="categoria" class="form-control" placeholder="Nombre de la categoría" required autofocus autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Agregar</button>
        </div>
      </div>
    </div>
  </form>
</div>

<br>
<div class="container">
<?php if (!empty($error)): ?>
  <div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $error ?>
  </div>
<?php endif ?>
  <div class="row">
    <div class="col-sm-3">
      <div class="list-group">
        <a href="#" class="list-group-item active">Categorías</a>
        <a href="#" class="list-group-item">Estadísticas</a>
      </div>
    </div>
    <div class="col-sm-9">
      <div class="panel panel-default">
        <table class="table table-striped table-hover ">
          <thead>
            <tr>
              <th>Categoria</th>
              <th>Publicaciones</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!$categorias->num_rows): ?>
            <tr>
              <td colspan="3" class="text-center">No se han encontrado categorías</td>
            </tr>
          <?php endif ?>
          <?php while( $categoria = $categorias->fetch_assoc() ){ ?>
            <tr>
              <td><?php echo $categoria['nombre'];?></td>
              <td><?php echo $categoria['pubs'];?></td>
              <td><a href="/Administracion.php?borrarCategoria=<?php echo $categoria['id'];?>">Borrar</a></td>
            </tr>
          <?php } ?>
            <tr>
              <td colspan="3" class="text-center"><a href="#" data-toggle="modal" data-target="#addCat">Agregar Categoría</a></td>
            </tr>
          </tbody>
        </table> 
      </div>
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>