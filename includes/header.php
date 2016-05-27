<!DOCTYPE html>
<html<?php if(isset($headerbg)):?> style="background: url('<?php echo $headerbg; ?>');background-size: cover;background-position: center center"<?php endif; ?>>
<head>
  <title>CouchInn</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, 
    maximum-scale=1.0, user-scalable=no"/>
  <link rel="icon" type="image/png" href="/img/logo.png" />
  <link rel="stylesheet" href="/css/reset.css" />
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
  <link rel="stylesheet" href="/css/animate.css" />
  <link rel="stylesheet" href="/css/main.css" />
</head>
<body>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand animated fadeIn" href="/"><img src="/img/logoc.png"></a>
      </div>

      <div class="collapse navbar-collapse" id="navbar">
        <div class="pull-left">
          <form class="navbar-form" role="search" method="GET">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Buscar" name="q">
              <div class="input-group-btn">
                  <button class="btn btn-default btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
              </div>
            </div>
          </form>
        </div>
        <ul class="nav navbar-nav navbar-right">
<?php if (isset($_SESSION['usuario'])): ?>
          <li>
            <p class="navbar-btn">
              <a href="/Agregar.php" class="btn btn-success">
                Agregar
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

  <div class="navbar navbar-default search-bar animated slideInDown">
    <div class="container">
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Localidad</label>
            <input type="text" class="form-control" placeholder="Localidad">
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label class="control-label">Categoría</label>
          <?php $categorias = $conexion->query("SELECT * FROM categoria"); ?>
            <select name="categoria" class="form-control">
            <?php while ( $categoria = $categorias->fetch_assoc() ){ ?>
              <option value="<?php echo $categoria['id']?>">
                <?php echo $categoria['nombre']?>
              </option>
            <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label class="control-label">Fecha entrada</label>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              <input type="text" class="form-control" placeholder="Entrada">
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label class="control-label">Fecha salida</label>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
              <input type="text" class="form-control" placeholder="Salida">
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Cantidad de personas</label>
            <div class="input-group">
              <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
              <input type="text" class="form-control" placeholder="Plazas">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  