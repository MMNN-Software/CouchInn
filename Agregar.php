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
            <div id="files" class="clearfix"></div>
            <span class="btn btn-success btn-block fileinput-button">
                <i class="glyphicon glyphicon-camera"></i>
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
                <textarea name="descripcion" class="form-control" rows="3" required="required" placeholder="Describe tu publicación detalladamente, cuanta más información indiques, mejores chances tenés de conseguir más huéspedes!"></textarea>
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

                <select name="capacidad" class="form-control" required="required">
                  <option value="0">Selecciona un valor</option>
                <?php for ($i=1; $i <= 50 ; $i++) { ?>
                  <option value="<?php echo $i?>">
                    <?php echo $i?> Persona<?php if($i!=1) echo 's';?>
                  </option>
                <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Lugar:</b></label>
              <div class="col-sm-10">
                <input type="hidden" name="idLugar" value="0" id="idLugar">
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

<style type="text/css">
  .fotoupload{
    position: relative;
  }

  .fotoupload .borrar{
    position: absolute;
    top: 5px;
    right: 10px;
  }
  #files{
    margin-bottom: 10px
  }
  #files:empty {
    min-height:100px;
    border:3px dashed #DDD;
  }
</style>
<?php 

$javascripts = <<<EOD
<script type="text/javascript">

function borrarFoto(e){
  $(e).parent().parent().remove();
  container.masonry('reloadItems');
  container.masonry('layout');
  return false;
}


$(document).ready(function(){
  $('textarea').elastic();
  var container = $('#files');

  window.container = container;

  container.imagesLoaded(function () {
    container.masonry({
      itemSelector: '.fotoupload',
      columnWidth: '.fotoupload',
      transitionDuration: 0
    });
  });


  $('#fileupload').fileupload({
      url: 'Agregar.php?im',
      dataType: 'json',
      acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
      done: function (e, data) {
          $.each(data.result.files, function (index, file) {
            console.log(file);
            if(file.error){
              //successAlert(file.error);
            }else{
              $('<div class="col-xs-6 col-md-4 col-lg-3 fotoupload">'+
              '<span class="borrar"><button class="btn btn-sm btn-danger" onclick="return borrarFoto(this);"><span class="glyphicon glyphicon-trash"></span></button></span>'+
              '<div class="thumbnail"><img src="'+file.url+'" /><input type="hidden" name="fotos[]" value="'+file.name+'"></div></div>').appendTo(container);
              
              container.imagesLoaded(function () {
                container.masonry('reloadItems');
                container.masonry('layout');
              });
            }
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