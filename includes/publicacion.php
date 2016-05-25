<div class="publicacion col-xs-12 col-sm-6 col-md-4 col-lg-3">
  <div class="panel panel-default">
    <a href="#"><?php if (rand(0,1)): ?>
        <img src="/img/logo.png">
      <?php else: ?>
        <img src="http://lorempixel.com/400/<?php echo rand(200,400); ?>/">
    <?php endif ?></a>
    <div class="panel-body">
      <h6><b>Casita</b></h6>
      <p>Descripcion</p>
    </div>
    <div class="panel-footer">
      <a href="#" class="btn btn-default text-danger" role="button"><span class="glyphicon glyphicon-heart"></span></a> 
      <a href="#" class="btn btn-default" role="button">Ver detalles</a>
    </div>
  </div>
</div>