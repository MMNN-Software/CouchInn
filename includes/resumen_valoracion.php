<?php

$resumen = $conexion->query("SELECT AVG(v.valor) as promedio, COUNT(*) as total
                              FROM valoracion v
							  INNER JOIN reserva r ON r.id=v.reserva_id
                              WHERE r.publicacion_id = '{$publicacion['id']}';");
$detalle = $conexion->query("SELECT v.valor, COUNT(*) as cant
                              FROM valoracion v
							  INNER JOIN reserva r ON r.id=v.reserva_id
                              WHERE r.publicacion_id = '{$publicacion['id']}'
                              GROUP BY v.valor
                              ORDER BY v.valor DESC;");
$resumen = $resumen->fetch_assoc();
$clases = ['','one','two','three','four','five'];
for ($i=1; $i <= 5; $i++){
  $detalles[$i]=0;
}
while( $val = $detalle->fetch_assoc() ){
  $detalles[intval($val['valor'])] = $val['cant'];
}

?><div class="rating-box">
  <div class="score-container">
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
  <div class="rating-histogram">
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