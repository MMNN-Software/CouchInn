 <div class="masonry" id="content">
      <!--<div><ul class="pager"><li><a href="/?page=1">Next</a></li></ul></div>-->
      <?php while( $publicacion = $publicaciones->fetch_assoc() ){ ?>
        <?php include 'includes/publicacion.php'; ?>
      <?php } ?>
    </div> 