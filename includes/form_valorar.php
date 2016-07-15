<form  class="form" action="/Perfil.php?tab=valoraciones" method="POST">
  <input type="hidden" name="rid" value="<?php echo $reserva['id']?>">
  <input type="hidden" name="uid" value="<?php echo $reserva['usuario_id']?>">
  <input type="hidden" name="valorar" value="siguacho">
  <div class="row">
    <div class="col-xs-8">
      <div class="form-group">
        <label class="control-label">Mensaje</label>        
        <input type="text"  class="form-control" id="mensaje" name="mensaje" class="form-control" placeholder="Mensaje" required>
      </div>
    </div>
    <div class="col-xs-4">
      <div class="form-group">
        <label class="control-label">Valoración</label>
        <select name="valoracion" class="form-control" required>
          <option value="">Seleccione valor</option>
          <option value="1">1 - Pésimo</option>
          <option value="2">2 - Malo</option>
          <option value="3">3 - Regular</option>
          <option value="4">4 - Buena</option>
          <option value="5">5 - Excelente</option>
        </select>
      </div>
    </div>
  </div>
  <button type="submit" class="btn btn-success pull-right">Enviar valoración</button>
</form>
