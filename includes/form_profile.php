<form action="/Perfil.php" method="POST" class="form-horizontal" role="form">
  <input type="hidden" name="update" value="1">
  <div class="panel panel-primary">
    <div class="panel-body">
      <h5>Detalles de la cuenta</h5>
      <hr>
      <div class="form-group">
        <label class="col-sm-2 control-label" control-label"><b>Correo:</b></label>
        <div class="col-md-10 form-control-static">
          <?php echo htmlentities($usuario_perfil['email'], ENT_QUOTES); ?> <span class="glyphicon glyphicon-question-sign" data-toggle="tooltip" data-placement="right" title="Tu dirección de correo es privada"></span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"><b>Contraseña:</b></label>
        <div class="col-md-10 form-control-static">
          <a href="#" data-toggle="modal" data-target="#modificarPassword">Cambiar</a>

        </div>
      </div>
      <h5>Detalles personales</h5>
      <hr>
      <div class="form-group">
        <label class="col-sm-2 control-label"><b>Tu nombre:</b></label>
        <div class="col-sm-10">
          <input type="text" name="nombre" class="form-control" value="<?php echo htmlentities($usuario_perfil['nombre'], ENT_QUOTES); ?>" required="required">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"><b>DNI:</b></label>
        <div class="col-sm-10">
          <input type="text" name="dni" class="form-control" value="<?php echo htmlentities($usuario_perfil['dni'], ENT_QUOTES); ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"><b>Religión:</b></label>
        <div class="col-sm-10">
          <input type="text" name="religion" class="form-control" value="<?php echo htmlentities($usuario_perfil['religion'], ENT_QUOTES); ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"><b>Biografía:</b></label>
        <div class="col-sm-10">
          <textarea class="form-control" rows="2" name="biografia"><?php echo $usuario_perfil['biografia'] ?></textarea>
          <span class="help-block">Tu bigrafía será publica y aparecerá en todas tus publicaciones.</span>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"><b>Domicilio:</b></label>
        <div class="col-sm-10">
          <input type="text" name="domicilio" class="form-control" value="<?php echo htmlentities($usuario_perfil['domicilio'], ENT_QUOTES); ?>">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-2 control-label"><b>Sexo:</b></label>
        <div class="col-sm-10">
          <select name="sexo" class="form-control">
            <option value=""<?php if (!$usuario_perfil['sexo']): ?> selected="selected"<?php endif ?>>Elige uno</option>
            <option value="F"<?php if ($usuario_perfil['sexo']=='F'): ?> selected="selected"<?php endif ?>>Mujer</option>
            <option value="M"<?php if ($usuario_perfil['sexo']=='M'): ?> selected="selected"<?php endif ?>>Hombre</option>
          </select>
        </div>
      </div>
    </div>
    <div class="panel-footer text-right">
      <button type="submit" class="btn btn-primary">Actualizar información</button>
    </div>
  </div>
</form>