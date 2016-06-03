<?php
  include 'includes/conexion.php';
  include 'includes/header.php';

  $publicaciones = $conexion->query("SELECT pu.id, pu.titulo, pu.capacidad, pu.descripcion, pu.fecha, ci.nombre as ciudad, pr.nombre as provincia, pu.ciudad_id, ca.nombre as categoria
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE ca.activa
ORDER BY pu.fecha DESC
/*LIMIT 8*/");

  $plazas = $conexion->query("SELECT capacidad FROM publicacion GROUP BY capacidad");

?>

  <div class="navbar navbar-default navbar-static-top search-bar" id="search-bar">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Categoría</label>
            <select name="categoria" class="form-control">
              <option value="0">Indistinto</option>
            <?php while ( $categoria = $categorias->fetch_assoc() ){ ?>
              <option value="<?php echo $categoria['id']?>">
                <?php echo $categoria['nombre']?>
              </option>
            <?php } ?>
            </select>
          </div>
        </div>
        <div class="input-daterange">
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha entrada</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" placeholder="Entrada" id="datein" name="datein">
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha salida</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input type="text" class="form-control" placeholder="Salida" id="dateout" name="dateout">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Cantidad de personas</label>
            <select name="plazas" class="form-control">
              <option value="0">Indistinto</option>
            <?php while ( $plaza = $plazas->fetch_assoc() ){ ?>
              <option value="<?php echo $plaza['capacidad']?>">
                <?php echo $plaza['capacidad']?> Persona<?php echo($plaza['capacidad']!=1)?'s':'';?>
              </option>
            <?php } ?>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container main">
    <?php if (isset($_GET["bienvenido"])): ?>
      <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Se ha registrado exitosamente!
      </div>
    <?php endif ?>
    <div class="masonry" id="content">
      <!--<div><ul class="pager"><li><a href="/?page=1">Next</a></li></ul></div>-->
      <?php while( $publicacion = $publicaciones->fetch_assoc() ){ ?>
        <?php include 'includes/publicacion.php'; ?>
      <?php } ?>
    </div> 
  </div>
<?php
$javascripts = <<<EOD

<script type="text/javascript">
  var rmOptions = {
    collapsedHeight: 160,
    speed: 1,
    moreLink: '<div class="text-center"><a href="#" class="readmore">Más <span class="glyphicon glyphicon-chevron-down"></span></a></div>',
    lessLink: '<div class="text-center"><a href="#" class="readmore">Menos <span class="glyphicon glyphicon-chevron-up"></span></a></div>',
    afterToggle: function(){ $('.masonry').masonry('layout');}
  };

  $(document).ready(function(){
    var container = $('#content');

    container.imagesLoaded(function () {
      container.masonry({
        itemSelector: '.publicacion',
        columnWidth: '.publicacion',
        transitionDuration: 0
      });
    });

    /*container.infinitescroll({
      animate:true,
      navSelector  : '.pager',    // selector for the paged navigation 
      nextSelector : '.pager a',  // selector for the NEXT link (to page 2)
      itemSelector : '.publicacion',     // selector for all items you'll retrieve
      loading: {
        finishedMsg: 'No hay más publicaciones para mostrar'
      },
      maxPage:2
    },function( newElements ) {
      var newElems = $( newElements );
      newElems.find('.descripcion').readmore(rmOptions);
      container.imagesLoaded(function () {
        container.masonry( 'appended', newElems );
      });
    });*/
    
    container.find('.publicacion .descripcion').readmore(rmOptions);

  });
</script>
EOD;

include 'includes/footer.php'; ?>