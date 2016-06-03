<div class="modal fade" id="modificarPassword">
  <form action="/Perfil.php" method="POST" class="form" role="form">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Cambiar contraseña</h4>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 col-md-offset-3">
              <div class="form-group">
                <label>Contraseña actual</label>
                <input type="password"  name="pass" class="form-control" placeholder="Contraseña" required autofocus autocomplete="off">
              </div>
              <div class="form-group">
                <label>Nueva contraseña</label>
                <input type="password"  name="npass" class="form-control" placeholder="Contraseña" required autocomplete="off">
              </div>
              <div class="form-group">
                <label>Repite nueva contraseña</label>
                <input type="password"  name="nrepass" class="form-control" placeholder="Contraseña" required autocomplete="off">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-primary">Cambiar</button>
        </div>
      </div>
    </div>
  </form>
</div>