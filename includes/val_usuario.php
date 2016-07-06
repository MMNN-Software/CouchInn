<div class="modal fade" id="valor_hospedaje">

  <form  class="form" action="/val_hospedaje.php?idp=<?php echo $pub['usuario_id']?>" method="POST">
    <div class="modal-dialog" style="max-width:400px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Valorar</h4>
        </div>
        <div class="modal-body">
          <form class="form" action="/val_hospedaje.php?idp=<?php echo $pub['usuario_id']?>" method="POST">
            <p>Se enviara una valoración al hospedaje</p>
			<div class="row">
			<div class="col-sm-12">
			 <div class="form-group">
            <label class="control-label">valoración</label>
            <select name="valoracion" class="form-control">
              <option value="1">1</option>
			  <option value="2">2</option>
			  <option value="3">3</option>
			  <option value="4">4</option>
			  <option value="5">5</option>
            
            </select>
          </div>
			</div>
			</div>  
			<div class="row">
			<div class="col-sm-12">
			<div class="form-group">
			   <label class="control-label">Mensaje</label>			   
				<div class="col-xs-12">
					<input type="text"  class="form-control" id="mensaje" name="mensaje" class="form-control" placeholder="Mensaje" required>
				</div>
			</div>
			</div>
			</div> 
			<div class="row">
			<div class="col-sm-12">
			<div class="form-group">			   
				<div class="col-xs-12">
					<input type ="hidden" value="<?php echo $pub['id']?>" class="form-control" id="idpubli" name="idpubli" class="form-control" >
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