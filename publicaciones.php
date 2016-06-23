<?php
  include 'includes/conexion.php';
  include 'includes/header.php';   
  $iduser = $conexion->real_escape_string((isset($_GET['id']))?$_GET['id']:$_SESSION['id']);
  
  
  $publicaciones = $conexion->query("SELECT pu.id, pu.titulo, pu.capacidad, pu.descripcion, pu.fecha, ci.nombre as ciudad, pr.nombre as provincia, pu.ciudad_id, ca.nombre as categoria
FROM publicacion pu
INNER JOIN categoria ca ON ca.id = pu.categoria_id
INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
INNER JOIN provincia pr ON pr.id = ci.provincia_id
WHERE ca.activa AND pu.usuario_id = $iduser
ORDER BY pu.fecha DESC
/*LIMIT 8*/");
  $plazas = $conexion->query("SELECT capacidad FROM publicacion GROUP BY capacidad");  

?>

<?php include 'includes/body.php'; 
if( $publicaciones->num_rows == 0 ){ 
$mensaje ="Aun no tienes publicaciones "?>
<form class="container main">
<div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <?php echo $mensaje ?>
      </div>
</form>	  
<?php
} else {
?>

 

  <div class="container main">
    <?php if (isset($_GET["bienvenido"])): ?>
      <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Se ha registrado exitosamente!
      </div>
    <?php endif ?>
   <?php include 'includes/mostrar_publi.php'; ?>
  </div>
<?php
}
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