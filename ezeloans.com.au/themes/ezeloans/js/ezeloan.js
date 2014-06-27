$(document).ready(function() {
	
	//only for loan page
	if($().easytabs) {
		$('#tab-container').easytabs();
	};
	
});


jQuery(document).ready(function() {
	
	if(jQuery().superfish){
		jQuery('.sf-menu').superfish({
			delay:       200,                            // one second delay on mouseout
			animation:   {opacity:'show'},  // fade-in and slide-down animation
			// speed:       'fast',   faster animation speed
			autoArrows:  true                            // disable generation of arrow mark-up
		});
	}

	
	if(jQuery().meanmenu){
	    jQuery('header nav').meanmenu({
			meanScreenWidth: "1140",
			meanMenuContainer: '#mobilemenu',
			meanMenuOpen: "<div><span></span><span></span><span></span></div>Menu"
		});
	}

  var $siteSearchForm = $('#SearchForm_SearchForm'),
      $siteSearchButton = $('.mn-search');
  
  var $siteSearchForm = $('#SearchForm_SearchForm'),
  $siteSearchButton = $('.mn-search');

	$('.head-search').on('click', 'a', function(e) {
	
	var HyperLink = $(this).attr('href');	
		
	if (HyperLink.search("#SearchForm_SearchForm")) {
	  e.preventDefault();
	  if ($siteSearchButton.hasClass('active')) {
	    $siteSearchButton.removeClass('active');
	    $siteSearchForm.removeClass('active');
	  } else {
	    $siteSearchButton.addClass('active');
	    $siteSearchForm.addClass('active')
	      .find('input').focus();
	  }
	}
	});
  
  $siteSearchForm.find('input').on('mousedownoutside', function(e) {
	if (e.target != $siteSearchButton.get(0)) {
      $siteSearchButton.removeClass('active');
      $siteSearchForm.removeClass('active');
    }
  });
});

(function($) {

	$.event.special.mousedownoutside = {
	  add: function(cb) {
	    var self = this,
	        name = 'mousedown.mousedownoutside' + cb.guid.toString();
	    
	    $(this).on(name, function(e) {
	      e.stopPropagation();
	    });
	    
	    $('body').on(name, function(e) {
	      var event = $.extend({}, e, {type: 'mousedownoutside'});
	      cb.handler.apply(self, [event]);
	    });
	  },
	  
	  remove: function(cb) {
	    var self = this,
	        name = 'mousedown.mousedownoutside' + cb.guid.toString();
	    
	    $(this).off(name);
	    $('body').off(name);
	  }
	};
	
	$.fn.extend({
	  mousedownoutside: function(fn) {
	    return fn ? this.on('mousedownoutside', fn) : this.trigger('mousedownoutside');
	  },
	  
	  unmousedownoutside: function(fn) {
	    return this.off('mousedownoutside', fn);
	  }
	});

})(jQuery);


skrollr.init({
	forceHeight: false,
	smoothScrolling: false
});
