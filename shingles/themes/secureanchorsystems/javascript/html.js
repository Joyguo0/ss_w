jQuery(document).ready(function() {
	var FIREFOX = /Firefox/i.test(navigator.userAgent);
	if (FIREFOX) {
		var pTags = $( "li.yo" );
		var newDiv = $("<div />", {
    		"class": "me"
    	}); 
		pTags.wrap(newDiv);
	}
})

jQuery(document).ready(function() {
	jQuery('ul.navigation').superfish({
		delay:       200,                            // one second delay on mouseout
		animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
		speed:       'fast',                          // faster animation speed
		autoArrows:  false                            // disable generation of arrow mark-up
	});
});

jQuery(document).ready(function () {
    jQuery('.nav-holder nav').meanmenu({
		meanScreenWidth: "768",
		meanMenuContainer: '#mobilemenu'
	});
});

$(document).ready(function() {
	 // MAKE SURE YOUR SELECTOR MATCHES SOMETHING IN YOUR HTML!!!
	 $('.hasTooltip').each(function() {
		 $(this).qtip({
			 content: {
				 text: $(this).next('div')
			 },
			 position: {
				my: 'bottom center',  // Position my top left...
				at: 'top center', // at the bottom right of...
				target: $(this) // my target
			},
			hide: {
				fixed: true
			},
			style: {
				classes: 'qtip-bootstrap',
				def: false
			}
		 });
	 });
	 
});

$(window).load(function() {
	$('.flexslider').flexslider({
		animation: "fade",
		controlNav: false,
		start: function(slider){
          $('.flexslider').removeClass('loading');
        }
	});
});

$(document).ready(function(){
    $('.carousel').bxSlider({
      responsive: true,
      slideWidth: 260,
      minSlides: 2,
      maxSlides: 4,
      moveSlides: 1,
      slideMargin: 34,
      pager: true,
		pagerType: 'short',
		pagerShortSeparator: '<span>of</span>',
      auto: true,
      pause: "3000"
    });
  });


$('.showmore').click(function(){
	
	var start_number = $(this).attr('data-start');
	var ajaxlink = $(this).attr('data-link');
	var showmoreDOM = $(this);
	
	$.ajax({
		   url: ajaxlink + "?start=" + start_number,
		   timeout: 5000,
		   type: "GET",
		   dataType: "json",
		   success: function(response) {
			   if(response.html){
				   
				   $('.ajaxcallback').before(response.html);
				   if(!(parseInt(response.start) + parseInt(response.length) < parseInt(response.sum))){
					   showmoreDOM.hide();
				   }else{
					   start_number = parseInt(response.start) + parseInt(response.length);
					   showmoreDOM.attr('data-start', start_number);
				   }
				   
				   
			   }
		   },
		   error: function(xhr) {
		    console.log(xhr);
		   }
	});
	
	
	
	
	
});


