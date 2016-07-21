<?php 
$valoraciones = $conexion->query("SELECT v.valor, v.mensaje, p.titulo, p.id as publicacion_id, 
            (SELECT i.path FROM imagen i WHERE i.publicacion_id = p.id ORDER BY i.id LIMIT 1) as imagen, ud.foto,
            (ud.id != p.usuario_id) as is_user, ud.id as user_id, ud.nombre
            FROM valoracion v
            INNER JOIN usuario u ON u.id = v.origen_usuario_id
            INNER JOIN usuario ud ON ud.id = v.destino_usuario_id
            INNER JOIN reserva r ON r.id = v.reserva_id
            INNER JOIN publicacion p ON p.id = r.publicacion_id
            WHERE v.origen_usuario_id = '{$_SESSION['id']}'
            ORDER BY v.fecha DESC");

if( $valoraciones->num_rows ){

?>

<div class="list-group valoraciones">
    <?php while( $val = $valoraciones->fetch_assoc() ): ?>
      <div class="list-group-item clearfix">

        <div class="featured-review-star-rating pull-right">
          <div class="tiny-star star-rating-non-editable-container">
            <div class="current-rating" style="width: <?php echo floor(($val['valor']*100)/5) ?>%;"></div>
          </div>
        </div>
        <span class="pull-left">
        <?php if($val['is_user']){ ?>
          <img src="/img/<?php echo ($val['imagen'])?'publicacion/'.$val['imagen']:'logo-pub.png'; ?>" style="height:100px;margin-right:10px" >
        <?php }else{ ?>
          <img src="/img/perfiles/<?php echo ($val['foto'])?$val['foto']:'default.png'; ?>" style="height:100px;margin-right:10px" >
        <?php } ?>
        </span>
        <?php if($val['is_user']){ ?>
          <h5 class="list-group-item-heading"><a href="/Publicacion.php?id=<?php echo $val['publicacion_id'] ?>"><?php echo $val['titulo']; ?></a></h5>
        <?php }else{ ?>
          <h5 class="list-group-item-heading"><a href="/Perfil.php?id=<?php echo $val['user_id'] ?>"><?php echo $val['nombre']; ?></a></h5>
        <?php } ?>
        <p class="list-group-item-text">"<i><?php echo $val['mensaje'] ?></i>"</p>
      </div>
  <?php endwhile; ?>
</div>

<?php }else{ ?>

<p class="text-center">Todavía no realizaste ninguna valoración</p>

<?php } ?>