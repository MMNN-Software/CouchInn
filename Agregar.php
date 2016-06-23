<?php
  include 'includes/conexion.php';

  include 'includes/isUser.php';

  if(isset($_GET['im'])){
    error_reporting(E_ALL | E_STRICT);
    require('includes/upload_handler.php');
    $upload_handler = new UploadHandler();
    die;
  }


  include 'includes/header.php';
  $categorias = $conexion->query("SELECT * FROM categoria WHERE activa = 1");
?>
<div class="container main">
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <h5>Agregar publicación</h5>
          <hr>
          <form action="Agregar.php" method="POST" class="form-horizontal">
            <div id="files"></div>
            <span class="btn btn-success btn-block fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Agregar fotos</span>
                <input id="fileupload" type="file" name="files[]" multiple>
            </span>
            <br>
            <br>
            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Título:</b></label>
              <div class="col-sm-10">
                <input type="text" name="titulo" class="form-control" required="required" placeholder="Título de la publicación">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Descripción:</b></label>
              <div class="col-sm-10">
                <textarea name="descripcion" class="form-control" rows="4" required="required" placeholder="Describe tu publicación detalladamente, cuanta más información indiques, mejores chances tenés de conseguir más huéspedes!"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Tipo:</b></label>
              <div class="col-sm-10">
                <select name="tipo" class="form-control" required="required">
                  <option value="0">Selecciona un tipo</option>
                <?php while ( $categoria = $categorias->fetch_assoc() ){ ?>
                  <option value="<?php echo $categoria['id']?>">
                    <?php echo $categoria['nombre']?>
                  </option>
                <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Plazas:</b></label>
              <div class="col-sm-10">
                <input type="number" name="capacidad" class="form-control" min="1" max="50" step="1" required="required">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Lugar:</b></label>
              <div class="col-sm-10">
                <input type="hidden" name="idLugar" value="-1" id="idLugar">
                <input type="text" name="lugar" class="form-control" required="required" id="autocompleteLugar">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-success">Enviar</button>
              </div>
            </div>
          </form>
        </div>
      </div>  
    </div>  
  </div>  
</div>
<?php 

$javascripts = <<<EOD
<script type="text/javascript">
$(document).ready(function(){
  $('#fileupload').fileupload({
      url: 'Agregar.php?im',
      dataType: 'json',
      acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
      done: function (e, data) {
          $.each(data.result.files, function (index, file) {
            console.log(file);
              $('<div class="col-xs-6 col-md-4 col-lg-3"><div href="#" class="thumbnail"><img src="'+file.url+'" /></div></div>').appendTo('#files');
          });
      }
  });
  $('#autocompleteLugar').autocomplete({
    source: function( request, response ) {
      $.ajax({
        url: "/ajax/ciudades.php",
        dataType: "json",
        data: {
          q: request.term
        },
        success: function( data ) {
          response( data );
        }
      });
    },
    minLength: 3,
    select: function( event, ui ) {
      $('#idLugar').val(ui.item.id);
    }
  }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.ciudad + ", " + item.provincia + " (" + item.publicaciones + ")</a>" )
        .appendTo( ul );
  };

});
</script>
EOD;

include 'includes/footer.php'; ?>