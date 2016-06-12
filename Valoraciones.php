<?php
  include 'includes/conexion.php';
  include 'includes/header.php';
?>

<div class="container main">
<div style="text-align:center">
<img style="width:70%; align:middle" src="/img/WorkInProgress.png" />
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