<?php
  include 'includes/conexion.php';

  //Verificacion de usuario logueado y admin
  include 'includes/isAdmin.php';


  if(isset($_GET['borrarCategoria'])){
    $categoria = $conexion->real_escape_string($_GET['borrarCategoria']);
    $conexion->query("UPDATE categoria SET activa = 0 WHERE id = '{$categoria}';");
    $mensaje = "Categoria borrada con éxito";
  }


  if(isset($_POST['categoria'])){
    $categoria = trim($_POST['categoria']);
    if( !empty($categoria) ){
      $categoria = $conexion->real_escape_string($categoria);
      $cat = $conexion->query("SELECT * FROM categoria WHERE nombre = '{$categoria}';");
      if($cat->num_rows){
        $categoria = $cat->fetch_assoc();
        if(!$categoria['activa']){
          $conexion->query("UPDATE categoria SET activa = 1 WHERE id = '{$categoria['id']}'");
          $mensaje = "Categoria agregada con éxito";
        }else{
          $error = "La categoría ya existe.";
        }
      }else{
        if(isset($_POST['id'])){
          $conexion->query("UPDATE categoria SET nombre = '{$categoria}' WHERE id = '{$_POST['id']}';");
          $mensaje = "Categoria actualizada con éxito";
        }else{
          $conexion->query("INSERT INTO categoria (id, nombre, activa) VALUES (NULL,'{$categoria}',1);");
          $mensaje = "Categoria agregada con éxito";
        }
      }
      $cat->free();
    }else{
      $error = "La categoría no puede estar vacía.";
    }
  }


  include 'includes/header.php';
  $categorias = $conexion->query("SELECT c.id as id, c.nombre as nombre, COUNT(p.id) as pubs FROM categoria c LEFT JOIN publicacion p ON p.categoria_id = c.id WHERE c.activa = 1 GROUP BY c.id, c.nombre ORDER BY c.nombre ASC");
?>
<div class="modal fade" id="addCat">
  <form action="/Categorias.php" method="POST" class="form" role="form">
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

<div class="modal fade" id="editCat">
  <form action="/Categorias.php" method="POST" class="form" role="form">
    <input type="hidden" name="id" value="">
    <div class="modal-dialog addcat-modal">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Modificar Categoría</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <input type="text"  name="categoria" class="form-control" placeholder="Nombre de la categoría" required autofocus autocomplete="off">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Modificar</button>
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
<?php if (!empty($mensaje)): ?>
  <div class="alert alert-dismissible alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $mensaje ?>
  </div>
<?php endif ?>

  <div class="col-sm-8 col-sm-offset-2">
  <div class="panel panel-default">
    <div class="panel-body">
      <a href="#" data-toggle="modal" data-target="#addCat" class="btn btn-primary pull-right">Agregar Categoría <span class="glyphicon glyphicon-plus"></span></a>
      <h5>Categorias</h5>
      <hr>
      <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th>Categoría</th>
            <th colspan="2">Publicaciones</th>
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
            <td style="text-align:right;padding: 5px 10px">
              <div class="btn-group">
                <a href="#" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#editCat" data-idcat="<?php echo $categoria['id'];?>" data-categoria="<?php echo htmlentities($categoria['nombre'], ENT_QUOTES);?>"><span class="glyphicon glyphicon-edit"></span> Editar</a>
                <a href="/Administracion.php?borrarCategoria=<?php echo $categoria['id'];?>" onclick="return confirm('Está seguro? Esta categoría cuenta con <?php echo $categoria['pubs'];?> publicacione<?php if($categoria['pubs']!=1):?>s<?php endif; ?>')" class="btn btn-sm btn-danger"><span class="glyphicon glyphicon-trash"></span> Borrar</a>
                </div>
              </td>
          </tr>
        <?php } ?>
        </tbody>
      </table> 
    </div>
  </div>
  </div>
</div>
<?php 
/*
$javascripts = <<<EOD
<script type="text/javascript">
$(document).ready(function(){
  $('#docked').sticky({topSpacing:80});
});
</script>
EOD;*/

include 'includes/footer.php'; ?>