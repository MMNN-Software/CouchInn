$(document).ready(function () {
    var $container = $('.masonry');

    $container.imagesLoaded(function () {
        $container.masonry({
            itemSelector: '.publicacion',
            columnWidth: '.publicacion',
            transitionDuration: 0
        });
    });
});