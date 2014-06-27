$( document ).ready(function() {
    
    $('.products-slider').slick({
      dots: true,
      infinite: true,
      placeholders: false,
      speed: 300,
      slidesToShow: 3,
      slidesToScroll: 1,
      responsive: [
        {
          breakpoint: 768,
          settings: {
            slidesToShow: 1,
            dots: true
          }
        }]
    });
    
    var $container = $('#gallery');
    $container.isotope({
        itemSelector: '.item',
        layoutMode : 'masonry',
        resizable: false,
        masonry: {
            columnWidth: Math.floor($container.width() / 3)
        }
    });
    
    $(window).resize(function(){
        $container.isotope({
            masonry: { columnWidth: $container.width() / 3 }
        });
    });
    
    $('#filters').on( 'click', 'a', function() {
      $('#filters a').removeClass('active');
      $(this).addClass('active');
      var filterValue = $(this).attr('data-filter');
      $container.isotope({ filter: filterValue });
    });
    
});

$(document).foundation({
    accordion: {
      active_class: 'active',
      multi_expand: false,
      toggleable: true
    }
  });
var doc = document.documentElement;
doc.setAttribute('data-useragent', navigator.userAgent);