<?php 
include 'includes/conexion.php';
include 'includes/header.php';
 ?> 
<br>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-md-offset-4">
        <form id="frmRestablecer" action="#">
          <div id="mensaje"></div>
          <div class="panel panel-default">
            <div class="panel-body">
              <h5>Recuperar contraseña</h5>
              <hr>
              <div class="form-group">
                <label for="email"> Escriba el correo asociado a su cuenta para recuperar su contraseña </label>
                <input type="email" id="email" class="form-control" name="email" autocomplete="off" placeholder="Correo electrónico" required autofocus="">
              </div>
            </div>
            <div class="panel-footer clearfix">
              <button class="btn btn-primary pull-right" type="submit">Recuperar contraseña</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

<?php include 'includes/footer.php'; ?>