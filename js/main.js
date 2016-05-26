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

  $('#editCat').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('idcat');
    var cat = button.data('categoria');
    var modal = $(this);
    modal.find('input[name=id]').val(id);
    modal.find('.modal-body input[name=categoria]').val(cat).focus();
  })

  $('#addCat').on('show.bs.modal', function (event) {
    var modal = $(this);
    modal.find('.modal-body input').focus();
  })

});