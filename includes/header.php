<?php $categorias = $conexion->query("SELECT * FROM categoria WHERE activa = 1"); ?><!DOCTYPE html>
<html<?php if(isset($headerbg)):?> style="background: url('<?php echo $headerbg; ?>');background-size: cover;background-position: center center"<?php endif; ?>>
<head>
  <title>CouchInn</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, 
    maximum-scale=1.0, user-scalable=no"/>
  <link rel="icon" type="image/png" href="/img/logo.png" />
  <link rel="stylesheet" href="/css/reset.css" />
  <link rel="stylesheet" href="/css/jquery-ui.min.css" />
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/css/bootstrap-datepicker3.css" />
  <link rel="stylesheet" href="/css/ekko-lightbox.min.css" />
  <link rel="stylesheet" href="/css/animate.css" />
  <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
  <nav class="navbar navbar-default navbar-inverse navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand animated fadeIn" href="/"><img src="/img/logow.png"></a>
      </div>

      <div class="collapse navbar-collapse" id="navbar">
  
        <div class="pull-left">
          <form class="navbar-form" role="search" method="GET">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="¿A qué ciudad querés ir?" name="ciudad" id="search_input">
              <span class="input-group-addon"><a href="#" style="color:white"><span class="glyphicon glyphicon-search"></span></a></span>
            </div>
          </form>
        </div>
        <ul class="nav navbar-nav navbar-right">
<?php if (isset($_SESSION['usuario'])): ?>
          <li>
            <p class="navbar-btn">
              <a href="/Agregar.php" class="btn btn-success">
                Agregar <span class="hidden-xs">Publicación</span>
              </a>
            </p>
          </li>
          <li class="dropdown"><?php include 'includes/user.php'; ?></li>
<?php else: ?>
          <li><a href="/Registrarse.php">Registrarse</a></li>
          <li class="dropdown<?php if(isset($_GET['login'])):?> open<?php endif;?>">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">Ingresar</a>
            <ul class="dropdown-menu" role="menu" id="login-dp">
              <li>
                <div class="row">
                  <div class="col-md-12">
                    <?php include 'includes/login.php'; ?>
                  </div>
                </div>
              </li>
            </ul>
          </li>
<?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>
