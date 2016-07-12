<?php 
  $usuario = $conexion->query("SELECT * FROM usuario WHERE id = '{$_SESSION['id']}'");
  $usuario = $usuario->fetch_assoc(); ?>
<li class="dropdown">
  <a href="#" class="dropdown-toggle profile-image" data-toggle="dropdown">
    <b><?php echo $_SESSION['nombre']; ?></b>
    <img src="/img/perfiles/<?php echo ($usuario['foto'])?$usuario['foto']:'default.png'; ?>" class="img-circle shadow">
    <b class="caret"></b>
  </a>
  <ul class="dropdown-menu">
  <?php if ($_SESSION['is_admin']): ?>
    <li><a href="/Administracion.php"><span class="glyphicon glyphicon-lock"></span> Administración</a></li>
  <?php endif ?>
    <li><a href="/Perfil.php"><span class="glyphicon glyphicon-user"></span> Mi Perfil</a></li>
    <li><a href="/Perfil.php?tab=publicaciones"><span class="glyphicon glyphicon-bed"></span> Publicaciones</a></li>	
    <li><a href="/Perfil.php?tab=reservas"><span class="glyphicon glyphicon-lamp"></span> Mis reservas</a></li>
    <li><a href="/Perfil.php?tab=favoritos"><span class="glyphicon glyphicon-heart"></span> Favoritos</a></li>
    <li><a href="/Perfil.php?tab=valoraciones"><span class="glyphicon glyphicon-star"></span> Valoraciones</a></li>
    <li class="divider"></li>
    <li><a href="/logout.php">Cerrar Sesión</a></li>
  </ul>
</li>