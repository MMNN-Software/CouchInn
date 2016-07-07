<?php
  include 'includes/conexion.php';

  //Verificacion de usuario logueado y admin
  include 'includes/isAdmin.php';

  setlocale(LC_MONETARY, 'es_AR');

  define("DATE_FORMAT","d-m-Y");

  $tab = (isset($_GET['tab']))?$_GET['tab']:'recaudacion';

  if(isset($_GET['hasta'])){
    $hasta = DateTime::createFromFormat(DATE_FORMAT,$_GET['hasta']);
  }else{
    $hasta = new Datetime('now');
  }

  if(isset($_GET['desde'])){
    $desde = DateTime::createFromFormat(DATE_FORMAT,$_GET['desde']);
  }else{
    $desde = (new Datetime('now'))->sub(new DateInterval("P1W"));
  }

  $dias = ($hasta->diff($desde,true))->format('%a');

  $link = '/Estadisticas.php?desde=' . $desde->format(DATE_FORMAT) . '&amp;hasta=' . $hasta->format(DATE_FORMAT);

  $usuarios = $conexion->query("SELECT u.id, u.nombre, u.foto, u.registro FROM usuario u WHERE activo = 1 AND DATE(u.registro) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."' ORDER BY u.registro");

  $reservas = $conexion->query("SELECT u.nombre, u.foto, r.publicacion_id, r.usuario_id, p.titulo, r.desde, r.hasta, r.fecha FROM reserva r INNER JOIN publicacion p ON p.id = r.publicacion_id INNER JOIN usuario u ON u.id = r.usuario_id WHERE r.estado = 2 AND DATE(r.fecha) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."' ORDER BY r.fecha");

  $pagos = $conexion->query("SELECT u.nombre, u.foto, p.usuario_id, p.fecha, p.monto FROM pago p INNER JOIN usuario u ON u.id = p.usuario_id WHERE DATE(p.fecha) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."' ORDER BY p.fecha");


  include 'includes/header.php';
?>
<br>
<style type="text/css">
  #daterange{
    max-width:350px;
    margin-top: 5px;
  }
</style>
<div class="container">
  <div class="row">
    <div class="panel panel-default clearfix">
      <div class="panel-body">
        <form action="/Estadisticas.php" method="GET" class="pull-right" role="form" id="daterange">
          <div class="input-daterange input-group">
            <input type="text" class="form-control" value="<?php echo $desde->format(DATE_FORMAT); ?>" name="desde" />
            <span class="input-group-addon">al</span>
            <input type="text" class="form-control" value="<?php echo $hasta->format(DATE_FORMAT); ?>" name="hasta" />
            <span class="input-group-btn">
              <button type="submit" class="btn btn-primary">Buscar</button>
            </span>
          </div>
          <input type="hidden" name="tab" value="<?php echo $tab?>">
        </form>
        <ul class="nav nav-pills">
          <li><h5 style="margin-right:20px">Estadísticas</h5></li>
          <li<?php if($tab=='recaudacion'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=recaudacion">Recaudación premium <span class="badge"><?php echo $pagos->num_rows ?></span></a></li>
          <li<?php if($tab=='reservas'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=reservas">Reservas efectuadas <span class="badge"><?php echo $reservas->num_rows ?></span></a></li>
          <li<?php if($tab=='usuarios'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=usuarios">Usuarios registrados <span class="badge"><?php echo $usuarios->num_rows ?></span></a></li>
        </ul>
        <hr />
        <?php
          switch ($tab) {
            case 'recaudacion':
              include('includes/stat_recaudacion.php');
              break;

            case 'reservas':
              include('includes/stat_reservas.php');
              break;

            case 'usuarios':
              include('includes/stat_usuarios.php');
              break;
            
            default:
              echo "Pestaña inválida";
              break;
          }
        ?>
      </div>
    </div>
  </div>
</div>
<?php 

$javascripts = <<<EOD
<script type="text/javascript">
$(document).ready(function(){
  
  $('#daterange .input-daterange').datepicker({
    format: "dd-mm-yyyy",
    endDate: "today",
    maxViewMode: 0,
    language: "es"
  });

});
</script>
EOD;

include 'includes/footer.php'; ?>