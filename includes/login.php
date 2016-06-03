<form class="form" role="form" method="POST" action="#" id="login_form">
  <input type="hidden" name="login" value="1">
  <div class="form-group">
    <label for="email">Dirección de correo electrónico</label>
    <input type="email" class="form-control" id="email" name="email" placeholder="hola@ingenieria.unlp" autocomplete="off" required autofocus>
  </div>
  <div class="form-group">
    <label for="password">Contraseña</label>
    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña" autocomplete="off" required>
    <div class="help-block">
      <a href="/Recuperar.php">Olvidaste tu contraseña?</a> - 
      <a href="/Registrarse.php">Registrarme</a>
    </div>
  </div>
  <p class="mensaje-de-error text-center text-danger"><?php if (isset($_GET['login'])): ?>Es necesario ingresar<?php endif ?></p>
  <div class="form-group">
    <button type="submit" class="btn btn-success btn-block">Ingresar</button>
  </div>
</form>