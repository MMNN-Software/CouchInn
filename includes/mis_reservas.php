<div class="panel panel-default">
  <div class="panel-body">
    
    <ul class="nav nav-pills">
      <li><h5 style="margin-right:20px">Reservas</h5></li>
      <li class="active"><a data-toggle="tab" href="#confirmadas">Todas</a></li>
      <li><a data-toggle="tab" href="#finalizadas">Finalizadas</a></li>
    </ul>

    <hr>

    <div class="tab-content">
      <div id="confirmadas" class="tab-pane fade in active">
      	<?php include('includes/reservas_confirmadas.php') ?>
      </div>
      <div id="finalizadas" class="tab-pane fade">
      	<?php include('includes/reservas_finalizadas.php') ?>
      </div>
    </div>

  </div>
</div>