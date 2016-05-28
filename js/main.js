$(document).delegate('*[data-toggle="lightbox"]', 'click', function(event) {
    event.preventDefault();
    $(this).ekkoLightbox();
}); 
var getUrlParameter = function getUrlParameter(sParam) {
    var sPageURL = decodeURIComponent(window.location.search.substring(1)),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : sParameterName[1];
        }
    }
};

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
          if( url = getUrlParameter('next')){
            document.location.href = url;
          }else{
            document.location.href = "/";
          }
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
  });
  
  $("#changeProfilePicture input[type=file]").change(function() {
      $(this).closest("form").submit();
  });

  $("#search_input").autocomplete({
    source: function( request, response ) {
      $.ajax({
        url: "/ciudades.php",
        dataType: "json",
        data: {
          q: request.term
        },
        success: function( data ) {
          response( data );
        }
      });
    },
    minLength: 3,
    select: function( event, ui ) {
      document.location.href = "/?ciudad="+ui.item.id;
    }
  }).autocomplete( "instance" )._renderItem = function( ul, item ) {
      return $( "<li>" )
        .append( "<a>" + item.ciudad + ", " + item.provincia + " (" + item.publicaciones + ")</a>" )
        .appendTo( ul );
  };

  $('#search-bar .input-daterange').datepicker({
    format: "dd/mm/yy",
    startDate: "today",
    maxViewMode: 0,
    language: "es",
    todayHighlight: true,
    autoclose: true
  });

  $('.container.main .masonry .publicacion .descripcion').readmore({
    collapsedHeight: 160,
    speed: 1,
    moreLink: '<div class="text-center"><a href="#" class="readmore">Más <span class="glyphicon glyphicon-chevron-down"></span></a></div>',
    lessLink: '<div class="text-center"><a href="#" class="readmore">Menos <span class="glyphicon glyphicon-chevron-up"></span></a></div>',
    afterToggle: function(){$('.masonry').masonry('layout');}
  });


  $('[data-toggle="tooltip"]').tooltip();
});