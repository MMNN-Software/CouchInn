<?php
  include 'includes/conexion.php';

  //Verificacion de usuario logueado y admin
  include 'includes/isAdmin.php';

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
          <li<?php if($tab=='recaudacion'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=recaudacion">Recaudación</a></li>
          <li<?php if($tab=='reservas'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=reservas">Reservas</a></li>
          <li<?php if($tab=='usuarios'): ?> class="active"<?php endif; ?>><a href="<?php echo $link ?>&amp;tab=usuarios">Usuarios</a></li>
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