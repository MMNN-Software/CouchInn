<form action="/filtrar.php" method="POST" class="form-horizontal">
  <div class="navbar navbar-default navbar-static-top search-bar" id="search-bar">
    <div class="container" >
      <div class="row">
        <div class="col-sm-3">
          <div class="form-group">
            <label class="control-label">Categoría</label>
            <select name="categoria" class="form-control">
              <option value="0">Indistinto</option>
            <?php while ( $categoria = $categorias->fetch_assoc() ){ ?>
              <option value="<?php echo $categoria['id']?>" id="categoria">
                <?php echo $categoria['nombre']?>
              </option>
            <?php } ?>
            </select>
          </div>
		  
        </div>
        <div class="input-daterange">
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha entrada</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input class="form-control" placeholder="Entrada" id="datein" name="datein">
              </div>
            </div>
			
			 
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label class="control-label">Fecha salida</label>
              <div class="input-group">
                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                <input class="form-control" placeholder="Salida" id="dateout" name="dateout">
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-2">
          <div class="form-group">
            <label class="control-label">Cantidad de personas</label>
            <select name="capac" class="form-control" >
              <option value="0">Indistinto</option>
            <?php while ( $plaza = $plazas->fetch_assoc() ){ ?>
              <option value="<?php echo $plaza['capacidad']?>" id="capac">
                <?php echo $plaza['capacidad']?> Persona<?php echo($plaza['capacidad']!=1)?'s':'';?>
              </option>
            <?php } ?>
            </select>
          </div>
        </div>
		<div class="col-sm-1">
			<label class="control-label">&nbsp;</label>
			<button type="submit" class="btn btn-primary">Buscar</button>
		</div>
      </div>
    </div>
	<div class="container" >
      <div class="row">
        <div class="col-sm-3">
			<div class="form-group">
					<label class="control-label">Ciudad</label>
			   <form  class="navbar-form" role="search" method="GET">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="¿A qué ciudad querés ir?" name="ciudad" id="search_input" >
				</div>
               </form>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
			   <label class="control-label">Titulo</label>
			   
				<div class="input-group">
					<input type="text"  class="form-control" id="titulo" name="titulo" class="form-control" placeholder="Titulo" >
				</div>
			</div>
		</div>
		<div class="col-sm-3">
			<div class="form-group">
			   <label class="control-label">Descripción</label>
			   
				<div class="input-group">
					<input type="text"  class="form-control" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción" >
				</div>
			</div>
		</div>
		</div>
	</div>
  </div>
</form>