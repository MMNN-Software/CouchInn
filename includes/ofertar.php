<div class="modal fade" id="ofertar">
  <form action="/confirmar_oferta.php" method="POST" class="form" role="form">
    <div class="modal-dialog" style="max-width:400px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Ofertar</h4>
        </div>
        <div class="modal-body">
          <form class="form" action="/confirmar_oferta.php" method="POST">
            <p>Se enviara una petición para poder llevar a cabo la reserva</p>
			<div class="row">
			<div class="col-sm-12">
			<div class="form-group">
			   <label class="control-label">Mensaje</label>			   
				<div class="col-xs-12">
					<input type="text"  class="form-control" id="mensaje" name="mensaje" class="form-control" placeholder="Mensaje" >
				</div>
			</div>
			</div>
			</div>
            <div class="row">
              <div class="input-daterange">
				  <div class="col-sm-6">
						<div class="form-group">
						  <label class="control-label">Fecha entrada</label>
						  <div class="input-group">
							<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
							<input class="form-control" placeholder="Entrada" id="datein" name="datein">
						  </div>
						</div>
						
					 
				  </div>
				  <div class="col-sm-6">
					<div class="form-group">
					  <label class="control-label">Fecha salida</label>
					  <div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
						<input class="form-control" placeholder="Salida" id="dateout" name="dateout">
					  </div>
					</div>
				  </div>
			  </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Ofertar</button>
        </div>
      </div>
    </div>
  </form>
</div>
