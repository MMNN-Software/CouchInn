<?php
  include 'includes/conexion.php';

  //Verificacion de usuario logueado y admin
  include 'includes/isAdmin.php';

  include 'includes/header.php';
?>
<br>
<div class="container">
  <div class="row">
    <div class="col-sm-3">
      <div class="list-group">
        <a href="#" class="list-group-item active">Categorías</a>
        <a href="#" class="list-group-item">Estadísticas</a>
      </div>
    </div>
    <div class="col-sm-9">
      <table class="table table-striped table-hover ">
        <thead>
          <tr>
            <th>Categoria</th>
            <th>Publicaciones</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
        <?php
        $categorias = $conexion->query("SELECT c.id as id, c.nombre as nombre, COUNT(p.id) as pubs FROM categoria c LEFT JOIN publicacion p ON p.categoria_id = c.id GROUP BY c.id, c.nombre ");
        while( $categoria = $categorias->fetch_assoc() ){ ?>
          <tr>
            <td><?php echo $categoria['nombre'];?></td>
            <td><?php echo $categoria['pubs'];?></td>
            <td><a href="/Administracion.php?borrarCategoria=<?php echo $categoria['id'];?>">Borrar</a></td>
          </tr>
        <?php } ?>
        </tbody>
      </table> 
    </div>
  </div>
</div>
<?php include 'includes/footer.php'; ?>