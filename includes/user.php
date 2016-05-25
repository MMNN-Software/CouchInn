<li class="dropdown">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <span class="glyphicon glyphicon-user"></span> 
    <?php echo $_SESSION['nombre']; ?>
    <span class="glyphicon glyphicon-chevron-down"></span>
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