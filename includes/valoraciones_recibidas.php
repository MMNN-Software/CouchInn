<?php
  $publicaciones = $conexion->query("SELECT 
    pu.id,
    pu.titulo,
    pu.capacidad,
    pu.descripcion,
    pu.fecha,
    pu.ciudad_id,
    pu.usuario_id,
    pu.categoria_id,
    ci.nombre as ciudad,
    pr.nombre as provincia,
    ca.nombre as categoria,
    u.id as owner_id,
    u.nombre as owner,
    u.biografia as biografia,
    u.sexo,
    u.foto,
    ca.activa
    FROM publicacion pu
    INNER JOIN categoria ca ON ca.id = pu.categoria_id
    INNER JOIN usuario u ON u.id = pu.usuario_id
    INNER JOIN ciudad ci    ON ci.id = pu.ciudad_id
    INNER JOIN provincia pr ON pr.id = ci.provincia_id
    WHERE u.id = '{$_SESSION['id']}' AND pu.estado");

if ( $publicaciones->num_rows ) { ?>
<div class="list-group valoraciones">
  <?php 
    while( $publicacion = $publicaciones->fetch_assoc() ): ?>
      <h5><?php echo $publicacion['titulo'] ?></h5>
        <div class="list-group valoraciones">
          <?php 
            $valoraciones = $conexion->query("SELECT v.valor, u.nombre, u.foto, v.mensaje
                FROM valoracion v
                INNER JOIN reserva r ON r.id = v.reserva_id
                INNER JOIN usuario u ON u.id = v.origen_usuario_id
                WHERE r.publicacion_id = '{$publicacion['id']}' AND v.destino_usuario_id = '{$_SESSION['id']}'
                ORDER BY v.mensaje DESC, v.fecha DESC");
            while( $val = $valoraciones->fetch_assoc() ): ?>

              <div class="list-group-item<?php if ($i>=5): ?> oculta<?php endif ?>">
                <div class="featured-review-star-rating pull-right">
                  <div class="tiny-star star-rating-non-editable-container">
                    <div class="current-rating" style="width: <?php echo floor(($val['valor']*100)/5) ?>%;"></div>
                  </div>
                </div>
                <img src="/img/perfiles/<?php echo ($val['foto'])?$val['foto']:'default.png'; ?>" class="img-circle shadow pull-left">
                <b><?php echo $val['nombre'] ?></b>
                <p class="list-group-item-text"><?php echo $val['mensaje'] ?></p>
              </div>
          <?php endwhile; ?>
        </div>
  <?php endwhile; ?>
</div>

<?php }else{ ?>

<p class="text-center">No tenes publicaciones.</p>

<?php } ?>