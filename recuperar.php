<?php 
include 'includes/conexion.php';
include 'includes/header.php';
 ?> 
   <div class="container" role="main">
      <div class="col-md-4"></div>
      <div class="col-md-4">
        <form id="frmRestablecer" action="/validaremail.php" method="post">
          <div class="panel panel-default">
            <div class="panel-heading"> Restaurar contraseña </div>
            <div class="panel-body">
              <p></p>
              <div class="form-group">
                <label for="email"> Escribe el email asociado a tu cuenta para recuperar tu contraseña </label>
                <input type="email" id="email" class="form-control" name="email" autocomplete="off" required>
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-success btn-block" value="Recuperar contraseña" >
              </div>
            </div>
          </div>
        </form>
        <div id="mensaje">
          
        </div>
      </div>
      <div class="col-md-4"></div>

    </div> <!-- /container -->
    <script>
      $(document).ready(function(){
        $("#frmRestablecer").submit(function(event){
          event.preventDefault();
          $.ajax({
            url:'/validaremail.php',
            type:'post',
            dataType:'json',
            data:$("#frmRestablecer").serializeArray()
          }).done(function(respuesta){
            $("#mensaje").html(respuesta.mensaje);
            $("#email").val('');
          });
        });
      });
    </script>
<?php include 'includes/footer.php'; ?>