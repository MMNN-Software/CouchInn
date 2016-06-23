<?php
  include 'includes/conexion.php';
  include 'includes/header.php';    	
  include 'includes/consulta.php';
  $plazas = $conexion->query("SELECT capacidad FROM publicacion GROUP BY capacidad");  

?>

 <?php include 'includes/body.php'; ?>

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