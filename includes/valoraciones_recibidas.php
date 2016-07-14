<?php
$resumen = $conexion->query("SELECT AVG(v.valor) as promedio, COUNT(*) as total
							  FROM valoracion v
							  WHERE v.destino_usuario_id = '{$_SESSION['id']}'");
$detalle = $conexion->query("SELECT v.valor, COUNT(*) as cant
							  FROM valoracion v
							  WHERE v.destino_usuario_id = '{$_SESSION['id']}'
							  GROUP BY v.valor
							  ORDER BY v.valor DESC");
$resumen = $resumen->fetch_assoc();
$clases = ['','one','two','three','four','five'];
for ($i=1; $i <= 5; $i++){
  $detalles[$i]=0;
}
while( $val = $detalle->fetch_assoc() ){
  $detalles[intval($val['valor'])] = $val['cant'];
}

$valoraciones = $conexion->query("SELECT v.valor, u.nombre, u.foto, v.mensaje, p.titulo, p.id as publicacion_id, r.desde, r.hasta
                                  FROM valoracion v
                                  INNER JOIN usuario u ON u.id = v.origen_usuario_id
                                  INNER JOIN reserva r ON r.id = v.reserva_id
                                  INNER JOIN publicacion p ON p.id = r.publicacion_id
                                  WHERE v.destino_usuario_id = '{$_SESSION['id']}'
                                  ORDER BY v.fecha DESC");

if ( $valoraciones->num_rows ) {
?>
<div class="rating-box row">
  <div class="score-container col-xs-6">
    <div class="score"><?php echo number_format($resumen['promedio'],1,',','.')?></div>
    <div class="score-container-star-rating">
      <div class="small-star star-rating-non-editable-container">
        <div class="current-rating" style="width: <?php echo floor(($resumen['promedio']*100)/5); ?>%;"></div>
      </div>
    </div>
    <div class="reviews-stats">
      <span class="reviewers-small"></span>
      <span class="reviews-num"><?php echo $resumen['total']; ?></span> en total
    </div>
  </div>
  <div class="rating-histogram col-xs-6">
    <?php for ($i=5; $i > 0; $i--): ?>
    <div class="rating-bar-container <?php echo $clases[$i] ?>">
      <span class="bar-label">
        <span class="star-tiny star-full"></span><?php echo $i ?>
      </span>
  <?php if ($resumen['total'] <> 0): ?>
      <span class="bar" style="width:<?php echo floor(($detalles[$i]*100)/$resumen['total']) ?>%"></span>
  <?php endif ?>
  <?php if ($resumen['total'] == 0): ?>
      <span class="bar" style="width:<?php echo floor(0.0) ?>%"></span>
  <?php endif ?>
      <span class="bar-number"><?php echo $detalles[$i] ?></span>
    </div>
    <?php endfor; ?>
  </div>
</div>

<div class="list-group valoraciones">
  <?php 
    while( $val = $valoraciones->fetch_assoc() ): ?>
      <div class="list-group-item">
        <div class="featured-review-star-rating pull-right">
          <div class="tiny-star star-rating-non-editable-container">
            <div class="current-rating" style="width: <?php echo floor(($val['valor']*100)/5) ?>%;"></div>
          </div>
        </div>
        <img src="/img/perfiles/<?php echo ($val['foto'])?$val['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
        <b><?php echo $val['nombre'] ?></b>
        en
        <a href="/Publicacion.php?id=<?php echo $val['publicacion_id'] ?>"><?php echo $val['titulo'] ?></a>
        desde el <?php echo (new DateTime($val['desde']))->format('d-m-Y'); ?> hasta el <?php echo (new DateTime($val['hasta']))->format('d-m-Y'); ?>
        <p class="list-group-item-text"><?php echo $val['mensaje'] ?></p>
      </div>
  <?php endwhile; ?>
</div>
<?php }else{ ?>

<p class="text-center">Todavía no recibiste ninguna valoración</p>

<?php } ?>