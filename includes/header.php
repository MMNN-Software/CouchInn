<!DOCTYPE html>
<html>
<head>
  <title>CouchInn</title>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, 
    maximum-scale=1.0, user-scalable=no"/>
  <link rel="icon" type="image/png" href="/img/logo.png" />
  <link rel="stylesheet" href="/css/reset.css" />
  <link rel="stylesheet" href="/css/bootstrap.min.css" />
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
        <a class="navbar-brand" href="/"><img src="/img/logoc.png"></a>
      </div>

      <div class="collapse navbar-collapse" id="navbar">
        <ul class="nav navbar-nav navbar-right">
        <?php if (isset($_SESSION['usuario'])): ?>
          <li class="dropdown"><?php include 'includes/user.php'; ?></li>
          <li>
            <p class="navbar-btn">
              <a href="/Agregar.php" class="btn btn-success">
                Agregar publicación
              </a>
            </p>
          </li>
        <?php else: ?>
          <li><a href="/Registrarse.php">Registrarse</a></li>
          <li class="dropdown"><?php include 'includes/login.php'; ?></li>
        <?php endif ?>
        </ul>
      </div>
    </div>
  </nav>

  