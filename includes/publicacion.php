<div class="publicacion col-xs-12 col-sm-6 col-md-4 col-lg-3">
  <div class="panel panel-default">
    <a href="#"><?php if (!rand(0,10)): ?>
        <img src="/img/logo-pub.png">
      <?php else: ?>
        <img src="/img/publicacion/<?php echo rand(1,9); ?>.jpg">
    <?php endif ?></a>
    <div class="panel-body">
      <h6><b>Casita</b></h6>
      <p>Descripcion</p>
    </div>
    <div class="panel-footer">
      <a href="#" class="btn btn-success btn-sm pull-right" role="button">Ver detalles</a>
      <a href="#" class="btn btn-danger btn-sm" role="button"><span class="glyphicon glyphicon-heart"></span></a> 
    </div>
  </div>
</div>