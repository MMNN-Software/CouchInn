<?php 
  $usuario = $conexion->query("SELECT * FROM usuario WHERE id = '{$_SESSION['id']}'");
  $usuario = $usuario->fetch_assoc(); ?>
<li class="dropdown">
  <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown">
    <img src="/img/perfiles/<?php echo ($usuario['foto'])?$usuario['foto']:'default.png'; ?>" class="img-circle shadow">
    <?php echo $_SESSION['nombre']; ?>
    <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
  <?php if ($_SESSION['is_admin']): ?>
    <li><a href="/Administracion.php">Administración</a></li>
  <?php endif ?>
    <li><a href="/Perfil.php">Mi Perfil</a></li>
    <!--<li><a href="/MisPublicaciones.php">Publicaciones</a></li>
    <li><a href="/MisPublicaciones.php">Valoraciones</a></li>-->
    <li class="divider"></li>
    <li><a href="/logout.php">Cerrar Sesión</a></li>
  </ul>
</li>