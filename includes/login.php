<a href="#" class="dropdown-toggle" data-toggle="dropdown">Ingresar</a>
<ul class="dropdown-menu" role="menu" id="login-dp">
  <li>
    <div class="row">
      <div class="col-md-12">
        <form class="form" role="form" method="POST" action="/Ingresar.php">
          <input type="hidden" name="login" value="1">
          <div class="form-group">
            <label for="email">Dirección de correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="hola@ingenieria.unlp" autocomplete="off" required autofocus>
          </div>
          <div class="form-group">
            <label for="password">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" autocomplete="off" required>
            <div class="help-block text-right">
              <div class="checkbox pull-left">
                <label><input type="checkbox"> Recordarme</label>
              </div>
              <div class="forgot">
                <a href="/Recuperar.php">Olvidaste tu contraseña?</a>
              </div>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
          </div>
        </form>
      </div>
      <div class="bottom text-center">
        Nuevo por aquí ? <a href="/Registrarse.php"><b>Registrate</b></a>
      </div>
    </div>
  </li>
</ul>