<?php 
$valoraciones = $conexion->query("SELECT v.valor, v.mensaje, p.titulo, p.id as publicacion_id, 
            (SELECT i.path FROM imagen i WHERE i.publicacion_id = p.id ORDER BY i.id LIMIT 1) as imagen
            FROM valoracion v
            INNER JOIN usuario u ON u.id = v.origen_usuario_id
            INNER JOIN reserva r ON r.id = v.reserva_id
            INNER JOIN publicacion p ON p.id = r.publicacion_id
            WHERE v.origen_usuario_id = '{$_SESSION['id']}'
            ORDER BY v.fecha DESC");

if( $valoraciones->num_rows ){

?><div class="list-group valoraciones">
    <?php while( $val = $valoraciones->fetch_assoc() ): ?>
      <div class="list-group-item clearfix">

        <div class="featured-review-star-rating pull-right">
          <div class="tiny-star star-rating-non-editable-container">
            <div class="current-rating" style="width: <?php echo floor(($val['valor']*100)/5) ?>%;"></div>
          </div>
        </div>
        <span class="pull-left">
          <img src="/img/<?php echo ($val['imagen'])?'publicacion/'.$val['imagen']:'logo-pub.png'; ?>" style="height:100px;margin-right:10px" >
        </span>
        <h5 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $val['publicacion_id'] ?>"><?php echo $val['titulo']; ?></a></h5>
        <p class="list-group-item-text">"<i><?php echo $val['mensaje'] ?></i>"</p>
      </div>
  <?php endwhile; ?>
</div>

<?php }else{ ?>

<p class="text-center">Todavía no realizaste ninguna valoración</p>

<?php } ?>