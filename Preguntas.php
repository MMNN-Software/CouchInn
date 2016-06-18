<?php
  include 'includes/conexion.php';
  include 'includes/header.php';
  include 'includes/functions.php';

function reply_question ( $preg_id, $user_id, $respuesta) {
	$error = 0;
    global $conexion;
    if( empty(strip_tags ($respuesta))) $error |= RESPUESTA_EMPTY;

    if($error) return $error;

    $preg_id = $conexion->real_escape_string($preg_id);
    $user_id = $conexion->real_escape_string($user_id);
    $respuesta = $conexion->real_escape_string(strip_tags ($respuesta));
    $tiempo = date("Y-m-d H:i:s");
	$conexion->query("INSERT INTO respuesta (id, respuesta, fecha) VALUES (NULL, '{$respuesta}', '{$tiempo}');");
	$conexion->query("UPDATE pregunta SET respuesta_id='{$conexion->insert_id}' WHERE id='{$preg_id}';");
	return 0;
}

if( isset($_POST['responder']) ){
	$error = reply_question(
      $_POST['responder'],
      $_SESSION['id'],
      $_POST['respuesta']);
	$res_agregada = 1;
	$mensaje = "Respuesta guardada exitosamente.";
	}
else {
    $res_agregada = 0;
}

  $preguntas = $conexion->query("SELECT pu.id AS pub_id,
									   pu.titulo AS pub_name,
									   pu.usuario_id AS owner_id,
									   pre.id AS preg_id,
									   pre.usuario_id AS preguntador_id,
									   pre.respuesta_id AS res_id,
									   u.foto AS foto,
									   u.nombre AS preguntador,
									   pre.pregunta AS pregunta,
									   UNIX_TIMESTAMP(pre.fecha) AS pre_fecha,
									   res.respuesta AS respuesta,
									   res.fecha AS res_fecha
								FROM pregunta pre
								INNER JOIN publicacion pu ON pu.id=pre.publicacion_id
								LEFT JOIN respuesta res ON res.id = pre.respuesta_id
								LEFT JOIN usuario u ON u.id=pre.usuario_id
								WHERE res.id IS NULL AND pu.usuario_id = '{$_SESSION['id']}'
								ORDER BY pu.titulo, pre.fecha DESC;");
								
if ($preguntas->num_rows) {
   $preg_res = array();
   while ( $prre = $preguntas->fetch_assoc()){
	   $preg_res[] = $prre;
   }
}

?>
  <div class="container main">
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="panel-body">
          <h5 id="Preguntas">Preguntas</h5>
		  <hr>
		  <?php if (!isset($preg_res)): ?>
		    Por el momento usted no tiene preguntas sin responder.
		  <?php else: ?>
		      <?php $old_value = 'not_defined' ?>
			  <?php 
				$i = 0;
				foreach ($preg_res AS $prre): ?>
				<?php if ($old_value != $prre['pub_name']): ?>
					<h4><a href="/Publicacion.php?id=<?php echo $prre['pub_id']?>"><?php echo $prre['pub_name'] ?></a></h4>
				<?php endif ?>
				<?php $old_value = $prre['pub_name'] ?>
				  <div class="media">
					<div class="media-left">
					  <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($prre['foto'])?$prre['foto']:'default.png'; ?>" width="48">
					</div>
					<div class="media-body">
					  <h5 class="media-heading"><small class="pull-right"><?php echo hace($prre['pre_fecha']) ?></small><a href="/Perfil.php?id=<?php echo $prre['preguntador_id']?>"><?php echo $prre['preguntador'] ?></a></h5>
					  <span style="width:100%"><?php echo strip_tags ((string)$prre['pregunta']) ?></span>
					  <?php if ($prre['respuesta'] !== NULL): ?>
						  <div class="developer-reply" style="width:100%; margin:7px; float:right">
							<div class="media-body" style="background:#e5e5e5; text-align:right">
							  <span><?php echo strip_tags ((string)$prre['respuesta']) ?></span>
							  <div class="box-arrow-up"></div>
							</div>
							<div class="media-right">
							  <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="32">
							</div>
						  </div>
					  <?php endif ?>
					  <?php if ($prre['respuesta'] == NULL && $_SESSION[id] == $prre[owner_id]): ?>
					  <form method="post" name="responder_<?php echo ($prre['preg_id']) ?>" action="/Preguntas.php" class="form" role="form">
						  <div class="developer-reply" style="width:100%; margin:7px; float:right">
							<div class="media-body">
							  <input type="hidden" name="responder" value="<?php echo ($prre['preg_id']) ?>" />
							  <textarea style="width:80%; background:#e5e5e5; font-color:black" rows="1" name="respuesta" placeholder="Escribe aqui la respuesta..." required id="preg_<?php echo ($prre['preg_id']) ?>"></textarea>
							  <input type="submit" class="btn btn-success" name="<?php echo ($prre['preg_id']) ?>" value="Responder" />
							  <div class="box-arrow-up"></div>
							</div>
							<div class="media-right">
							  <img class="media-object img-circle shadow" src="/img/perfiles/<?php echo ($publicacion['foto'])?$publicacion['foto']:'default.png'; ?>" width="32">
							</div>
						  </div>
					  </form>
					  <?php endif ?>
					</div>
				  </div>
				  <hr>
			  <?php endforeach ?>
		  <?php endif ?>
          </div>
		</div>
      </div>
  </div>
<?php 
$javascripts = <<<EOD
<script type="text/javascript">
$(document).ready(function(){
  $('.publicacion-header').sticky({topSpacing:64});
});
</script>
EOD;
include 'includes/footer.php'; ?>

<?php if ($res_agregada == 1): ?>
<script>
	$(function(){successAlert('Exito', 'La respuesta fue guardada exitosamente.');
				});
</script>
<?php endif ?>
