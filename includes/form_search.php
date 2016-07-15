<form action="/" method="GET">
  <div class="navbar navbar-default navbar-static-top search-bar" id="search-bar">
    <div class="container">
      <div class="row">
        <div class="input-daterange">
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha entrada</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input class="form-control" placeholder="Entrada" id="datein" name="datein" value="<?php echo htmlentities($_GET['datein'], ENT_QUOTES); ?>">
              </div>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha salida</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input class="form-control" placeholder="Salida" id="dateout" name="dateout" value="<?php echo htmlentities($_GET['dateout'], ENT_QUOTES); ?>">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Categoría</label>
            <select name="categoria" class="form-control">
              <option value="0">Indistinto</option>
              <?php while ( $categoria = $categorias->fetch_assoc() ){ ?>
                <option value="<?php echo $categoria['id']?>"<?php if($categoria['id']==$_GET['categoria']) echo ' selected'; ?>>
                  <?php echo $categoria['nombre']?>
                </option>
                <?php } ?>
              </select>
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Cantidad de personas</label>
              <select name="capac" class="form-control" >
                <option value="0">Indistinto</option>
                <?php 
                $plazas = $conexion->query("SELECT capacidad FROM publicacion GROUP BY capacidad");
                while ( $plaza = $plazas->fetch_assoc() ){ ?>
                  <option value="<?php echo $plaza['capacidad']?>"<?php if($plaza['capacidad']==$_GET['capac']) echo ' selected'; ?>>
                    <?php echo $plaza['capacidad']?> Persona<?php echo($plaza['capacidad']!=1)?'s':'';?>
                  </option>
                  <?php }
                  $plazas->free(); ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label">Ciudad</label>
                <input type="text" class="form-control" placeholder="Ciudad" name="ciudad" id="search_input" value="<?php echo htmlentities($_GET['ciudad'], ENT_QUOTES); ?>">
              </div>
            </div>

            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label">Titulo</label>
                <input type="text"  class="form-control" id="titulo" name="titulo" class="form-control" placeholder="Titulo" value="<?php echo htmlentities($_GET['titulo'], ENT_QUOTES); ?>">
              </div>
            </div>
            
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label">Descripción</label>
                <input type="text"  class="form-control" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" value="<?php echo htmlentities($_GET['descripcion'], ENT_QUOTES); ?>">
              </div>
            </div>
            
            <div class="col-sm-3">
              <div class="form-group">
                <label class="control-label">Ordenar por</label>
                <select name="ordenar" class="form-control">
                  <option value="">Seleccione un orden</option>           
                  <option value="1"<?php if($_GET['ordenar']==1) echo ' selected'; ?>>Fecha</option>            
                  <option value="2"<?php if($_GET['ordenar']==2) echo ' selected'; ?>>Nombre</option>
                  <option value="3"<?php if($_GET['ordenar']==3) echo ' selected'; ?>>Valoración</option>             
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="form-group text-right">
              <button type="reset" class="btn btn-primary">Limpiar</button>
              <button type="submit" class="btn btn-success">Buscar <span class="glyphicon glyphicon-search"></span></button>
            </div>
          </div>

        </div>
      </div>
    </form>