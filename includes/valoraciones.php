<div class="panel panel-default">
  <div class="panel-body">
      
    <ul class="nav nav-pills">
      <li><h5 style="margin-right:20px">Valoraciones</h5></li>
      <li class="active"><a data-toggle="tab" href="#recibidas">Recibidas</a></li>
      <li><a data-toggle="tab" href="#dadas">Dadas</a></li>
      <li><a data-toggle="tab" href="#pordar">Por Dar</a></li>
    </ul>

    <hr>

    <div class="tab-content">
      <div id="recibidas" class="tab-pane fade in active">
        <?php include 'includes/valoraciones_recibidas.php'; ?>
      </div>
      <div id="dadas" class="tab-pane fade">
        <?php include 'includes/valoraciones_dadas.php'; ?>
      </div>
      <div id="pordar" class="tab-pane fade">
        <?php include 'includes/valoraciones_pordar.php'; ?>
      </div>
    </div>

  </div>
</div>