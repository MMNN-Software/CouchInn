<?php
  include 'includes/conexion.php';
  include 'includes/header.php';

  $sql = "SELECT pu.id,
         pu.titulo,
         pu.capacidad,
         pu.descripcion,
         pu.fecha,
         ci.nombre as ciudad,
         pr.nombre as provincia,
         pu.ciudad_id,
         ca.nombre as categoria,
         COALESCE(val.promedio,0.0) as ranking
  FROM publicacion pu
  INNER JOIN categoria ca ON ca.id = pu.categoria_id
  INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
  INNER JOIN provincia pr ON pr.id = ci.provincia_id
  INNER JOIN (SELECT p.id AS publicacion_id, COALESCE(AVG(v.valor), 0.0) as promedio, COUNT(*) as total
  FROM publicacion p
  LEFT JOIN reserva r ON r.publicacion_id=p.id
  LEFT JOIN valoracion v ON r.id=v.reserva_id
  GROUP BY p.id) val ON val.publicacion_id = pu.id
  WHERE ca.activa AND pu.estado ";

  $orden = $_GET['ordenar'];
  $categoria = $_GET['categoria'];
  $ciudad = $_GET['ciudad'];
  $entrada = $_GET['datein'];
  $salida = $_GET['dateout'];
  $capacidad = $_GET['capac'];
  $titulo = $conexion->real_escape_string($_GET['titulo']);
  $descripcion = $conexion->real_escape_string($_GET['descripcion']);


  if ($categoria != 0) {
    $sql .= "AND ca.id = $categoria "; 
  }

  if ($descripcion != "") {
    $sql .= "AND pu.descripcion like '%$descripcion%' "; 
  }

  if ($titulo <> "") {
    $sql .= "AND pu.titulo like '%$titulo%' "; 
  }

  if ($ciudad <> "") {  
    $prov = substr($ciudad, (strpos($ciudad,',')+1));
    $ciu = substr($ciudad, 0, strpos($ciudad, ','));
    $prov = ltrim($prov);
    $prov1 = $conexion->query("SELECT * FROM provincia WHERE nombre like '%$prov%' ");
    $prov1 = $prov1->fetch_assoc();
    $prov1 = $prov1['id'];
    $ciu = ltrim($ciu);
    $sql .= "AND ci.nombre like '%$ciu%' AND pr.id = $prov1 ";
  }

  if ($capacidad <> 0) {
    $sql .= "AND pu.capacidad = $capacidad "; 
  }

  if ($entrada <> "") {
    $fentrada = DateTime::createFromFormat('d/m/Y', $entrada)->format('Y-m-d');
    $fsalida = DateTime::createFromFormat('d/m/Y', $salida)->format('Y-m-d'); 
    $sql .= "AND pu.id NOT IN (SELECT publicacion_id FROM reserva r WHERE r.estado = 2 AND '$fentrada' BETWEEN r.desde AND r.hasta OR '$fsalida' BETWEEN r.desde AND r.hasta AND r.desde BETWEEN '$fentrada' AND'$fsalida' OR r.hasta BETWEEN '$fentrada' AND'$fsalida') ";  
  }


  switch ($orden) {
    case 1:
      $sql .= "ORDER BY pu.fecha DESC";
      break;

    case 2:
      $sql .= "ORDER BY pu.titulo ASC";
      break;

    case 3:
      $sql .= "ORDER BY promedio DESC";
      break;
    
    default:
      $sql .= "ORDER BY pu.fecha DESC";
      break;
  }

  $publicaciones = $conexion->query($sql);

  include 'includes/form_search.php'; ?>

  <div class="container main">
    <?php if (isset($_GET["bienvenido"])): ?>
      <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        Se ha registrado exitosamente!
      </div>
    <?php endif ?>
    <div class="masonry" id="content">
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