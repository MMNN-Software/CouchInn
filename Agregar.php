<?php
  include 'includes/conexion.php';

  include 'includes/isUser.php';

  if(isset($_GET['im'])){
    error_reporting(E_ALL | E_STRICT);
    require('includes/upload_handler.php');
    $upload_handler = new UploadHandler();
    die;
  }

  if(isset($_GET['save'])){
    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $descripcion = $conexion->real_escape_string($_POST['descripcion']);
    if(isset($_POST['id'])){
      $ands = '';
      $i = 0;
      foreach ($_POST['viejas'] as $id) {
        $i++;
        $ands .= ' AND id != \''.$id."'";
      }
      $conexion->query("DELETE FROM imagen WHERE publicacion_id = '{$_POST['id']}'".$ands);
      foreach ($_POST['fotos'] as $foto) {
        $i++;
        $path = $conexion->real_escape_string($foto);
        $conexion->query("INSERT INTO imagen(id, publicacion_id, `path`, orden) VALUES (NULL,'{$_POST['id']}','{$path}','{$i}')");
      }
      $conexion->query("UPDATE publicacion SET categoria_id = '{$_POST['tipo']}', ciudad_id = '{$_POST['idLugar']}', titulo = '{$titulo}', descripcion = '{$descripcion}', capacidad = '{$_POST['capacidad']}' WHERE id = '{$_POST['id']}'");
      header("Location: /Publicacion.php?id=".$_POST['id']);
      die;
    }else{
      $dd = date('Y-m-d H:i:s');
      $conexion->query("INSERT INTO publicacion(id, categoria_id, ciudad_id, usuario_id, titulo, descripcion, fecha, capacidad) 
        VALUES (NULL,'{$_POST['tipo']}','{$_POST['idLugar']}','{$_SESSION['id']}','{$titulo}','{$descripcion}','{$dd}','{$_POST['capacidad']}')");
      $id = $conexion->insert_id;
      $i = 0;
      foreach ($_POST['fotos'] as $foto) {
        $i++;
        $path = $conexion->real_escape_string($foto);
        $conexion->query("INSERT INTO imagen(id, publicacion_id, `path`, orden) VALUES (NULL,'{$id}','{$path}','{$i}')");
      }
      header("Location: /Publicacion.php?id=".$id);
      die;
    }
  }

  if(isset($_GET['editar'])){
    $id = $conexion->real_escape_string($_GET['editar']);
    $publicaciones = $conexion->query("SELECT p.id, p.titulo, p.descripcion, p.categoria_id, p.capacidad, p.ciudad_id, c.nombre as ciudad, pr.nombre as provincia
                                  FROM publicacion p 
                                  INNER JOIN ciudad c ON c.id = p.ciudad_id
                                  INNER JOIN provincia pr ON pr.id = c.provincia_id
                                  WHERE p.id = '{$id}'");

    if($publicaciones->num_rows){
      $publicacion = $publicaciones->fetch_assoc();

      $img = $conexion->query("SELECT id, path FROM imagen WHERE publicacion_id = '{$publicacion['id']}' ORDER BY orden ASC");
      $imagenes = array();
      while( $im = $img->fetch_assoc() ){
        $imagenes[] = $im;
      }
      $img->free();

    }else{
      $error = "La publicación no existe";
    }
  }

  include 'includes/header.php';
  $categorias = $conexion->query("SELECT * FROM categoria WHERE activa = 1");
?>
<div class="container main">
  <div class="row">
    <div class="col-sm-8 col-sm-offset-2">
      <div class="panel panel-default">
        <div class="panel-body">
          <h5><?php echo ($publicacion)?'Editar':'Agregar'; ?> publicación</h5>
          <hr>
          <form action="Agregar.php?save" method="POST" class="form-horizontal">
            <?php if ($publicacion): ?><input type="hidden" name="id" value="<?php echo $publicacion['id'] ?>"><?php endif ?>
            <div id="files" class="clearfix">
			<?php if ($publicacion): ?>
				<?php $i = 0; foreach ($imagenes as $img): ?>
				<div class="col-xs-6 col-md-4 col-lg-3 fotoupload"><span class="borrar"><button class="btn btn-sm btn-danger" onclick="return borrarFoto(this);"><span class="glyphicon glyphicon-trash"></span></button></span><div class="thumbnail"><img src="/img/publicacion/<?php echo $img['path'] ?>" /><input type="hidden" name="viejas[]" value="<?php echo $img['id'] ?>"></div></div>
				<?php endforeach ?>
			<?php endif ?>
			</div>
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
                <input type="text" name="titulo" class="form-control" required="required" placeholder="Título de la publicación" value="<?php echo htmlentities($publicacion['titulo'], ENT_QUOTES); ?>">
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Descripción:</b></label>
              <div class="col-sm-10">
                <textarea name="descripcion" class="form-control" rows="3" required="required" placeholder="Describe tu publicación detalladamente, cuanta más información indiques, mejores chances tenés de conseguir más huéspedes!"><?php echo $publicacion['descripcion'] ?></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Tipo:</b></label>
              <div class="col-sm-10">
                <select name="tipo" class="form-control" required="required">
                  <option value="">Selecciona un tipo</option>
                <?php while ( $categoria = $categorias->fetch_assoc() ){ ?>
                  <option value="<?php echo $categoria['id']?>"<?php if($publicacion['categoria_id'] == $categoria['id']): ?> selected<?php endif ?>>
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
                  <option value="">Selecciona un valor</option>
                <?php for ($i=1; $i <= 50 ; $i++) { ?>
                  <option value="<?php echo $i?>"<?php if($publicacion['capacidad'] == $i): ?> selected<?php endif ?>>
                    <?php echo $i?> Persona<?php if($i!=1) echo 's';?>
                  </option>
                <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><b>Lugar:</b></label>
              <div class="col-sm-10">
                <input type="hidden" name="idLugar" value="<?php echo ($publicacion['ciudad_id'])?$publicacion['ciudad_id']:'' ?>" id="idLugar">
                <input type="text" name="lugar" class="form-control" required="required" id="autocompleteLugar" value="<?php if($publicacion) echo htmlentities($publicacion['ciudad'], ENT_QUOTES).', '.htmlentities($publicacion['provincia'], ENT_QUOTES); ?>">
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-10 col-sm-offset-2">
                <button type="submit" class="btn btn-success">Guardar</button>
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