<div class="modal fade" id="mejorarCuenta">
  <form action="/Perfil.php" method="POST" class="form" role="form">
    <div class="modal-dialog" style="max-width:400px">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Mejorar Cuenta</h4>
        </div>
        <div class="modal-body">
          <form class="form" action="/Perfil.php" method="POST">
            <p>Se te cobrará un costo de membresía por única vez de $150</p>
            <div class="row">
              <div class="col-xs-12">
                <label class="control-label">Número de tarjeta</label>
                <div class="input-group">
                  <input type="text"  name="tarjeta" class="form-control" onkeypress="validateNumberField(event)" placeholder="XXXXXXXXXXXXXXXX" minlength="16" maxlength="16" required autofocus autocomplete="off" pattern="^[0-9]{16}$" title="El numero de tarjeta debe ser de 16 digitos." />
                  <span class="input-group-addon"><span class="glyphicon glyphicon-credit-card"></span></span>
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label">Fecha de vencimiento</label>
                  <input type="text" pattern="^([01][0-2]|0?[1-9])\/[1-5][0-9]$" name="expires" class="form-control" placeholder="MM/AA" minlength="5" maxlength="5" required autocomplete="off" title="La fecha de vencimiento debe ser posterior a hoy." />
                </div>
              </div>
              <div class="col-xs-6">
                <div class="form-group">
                  <label class="control-label">Código de seguridad</label>
                  <input type="text" pattern="^[0-9]{3,4}$" onkeypress="validateNumberField(event)" name="ccv" class="form-control" placeholder="XXX" required autocomplete="off" minlength="3" maxlength="4" title="El codigo de seguridad debe ser de 3 digitos." />
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success">Mejorar</button>
        </div>
      </div>
    </div>
  </form>
</div>
<script type="text/javascript">
function validateNumberField(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>