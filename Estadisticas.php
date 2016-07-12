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

  $dias = $hasta->diff($desde,true);
  $dias = $dias->format('%a');

  $link = '/Estadisticas.php?desde=' . $desde->format(DATE_FORMAT) . '&amp;hasta=' . $hasta->format(DATE_FORMAT);

  $usuarios = $conexion->query("SELECT u.id, u.nombre, u.foto, u.registro FROM usuario u WHERE activo = 1 AND DATE(u.registro) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."' ORDER BY u.registro");

  $reservas = $conexion->query("SELECT u.nombre, u.foto, r.publicacion_id, r.usuario_id, p.titulo, r.desde, r.hasta, r.fecha FROM reserva r INNER JOIN publicacion p ON p.id = r.publicacion_id INNER JOIN usuario u ON u.id = r.usuario_id WHERE r.estado = 2 AND DATE(r.fecha) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."' ORDER BY r.fecha");

  $pagos = $conexion->query("SELECT u.nombre, u.foto, p.usuario_id, p.fecha, p.monto FROM pago p INNER JOIN usuario u ON u.id = p.usuario_id WHERE DATE(p.fecha) BETWEEN '".$desde->format("Y-m-d")."' AND '".$hasta->format("Y-m-d")."' ORDER BY p.fecha");


  include 'includes/header.php';
?>
<br>
<style type="text/css">
  #daterange{
    margin-top: 5px;
  }
</style>
<div class="container">
  <div class="row">

    <div class="panel panel-default clearfix">
      <div class="panel-body">
        <button class="btn btn-primary pull-right" type="button" id="daterange">
          <span class="glyphicon glyphicon-calendar"></span>
          <b></b>
          <span class="caret"></span>
        </button>
        <ul class="nav nav-pills">
          <li><h5 style="margin-right:20px">Estadísticas</h5></li>
          <li<?php if($tab=='recaudacion'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=recaudacion">Recaudación <span class="badge"><?php echo $pagos->num_rows ?></span></a></li>
          <li<?php if($tab=='reservas'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=reservas">Reservas <span class="badge"><?php echo $reservas->num_rows ?></span></a></li>
          <li<?php if($tab=='usuarios'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=usuarios">Usuarios <span class="badge"><?php echo $usuarios->num_rows ?></span></a></li>
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


function loadEstadistica(start,end){
  document.location = "/Estadisticas.php?desde="+start.format('DD-MM-YYYY')+"&hasta="+end.format('DD-MM-YYYY')+"&tab={$tab}";
}


$(document).ready(function(){

var start = moment("{$desde->format('Y-m-d')}");
var end = moment("{$hasta->format('Y-m-d')}");

$('#daterange b').html(start.format('D MMMM YYYY') + ' - ' + end.format('D MMMM YYYY'));

$('#daterange').daterangepicker({
    startDate: start,
    endDate: end,
    autoUpdateInput: false,
    autoApply: true,
    ranges: {
       'Hoy': [moment(), moment()],
       'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
       'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
       'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
       'Este mes': [moment().startOf('month'), moment().endOf('month')],
    }, 
    "locale": {
        "format": "DD/MM/YYYY",
        "separator": " - ",
        "applyLabel": "Aplicar",
        "cancelLabel": "Cancelar",
        "fromLabel": "Desde",
        "toLabel": "Hasta",
        "customRangeLabel": "Personalizado",
        "weekLabel": "S",
        "daysOfWeek": [
            "Dom",
            "Lun",
            "Mar",
            "Mie",
            "Jue",
            "Vie",
            "Sáb"
        ],
        "monthNames": [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre"
        ],
        "firstDay": 1
    }
}, loadEstadistica);



});

</script>
EOD;

include 'includes/footer.php'; ?>