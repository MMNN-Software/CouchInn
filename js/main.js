$(document).ready(function () {
    var $container = $('.masonry');

    $container.imagesLoaded(function () {
        $container.masonry({
            itemSelector: '.publicacion',
            columnWidth: '.publicacion',
            transitionDuration: 0
        });
    });


    $('#login_form').on('submit',function(e){
      e.preventDefault();
      $.ajax({
        method: 'POST',
        url: '/login.php',
        cache: false,
        dataType: 'JSON',
        data: $(this).serialize(),
        success: function(data){
          console.log(data);
          if(data.estado){
            document.location.href = "/";
          }else{
            $('#login_form .mensaje-de-error').html(data.mensaje);
          }
        }
      });
    });
});