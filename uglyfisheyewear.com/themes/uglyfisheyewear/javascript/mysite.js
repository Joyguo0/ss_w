$(document).foundation('orbit', {
    orbit_transition_class: 'my-transition',
    animation: 'fade',
    timer_speed: 5000,
    directionalNav: false, // manual advancing directional navs
    captions: false,
    timer: false,
    pause_on_hover: true,
    animation_speed: 500,
    navigation_arrows: false,
    bullets: true,
    slide_number: false,
    next_on_click: true
});



$(function() {
$(document).ready(function() {
	
    $('.search .go , form .add-to-cart').click(function() {
        $(this).parent('form').submit();
    });
    
    $('.horizontal-nav').horizontalNav({
        responsive: true,
        tableDisplay: true
    });
    
    // Find the toggles and hide their content
    $('.toggle').each(function() {
        $(this).find('.toggle-content').hide();
    });

    // Find the toggles and hide their content
    $('.toggle.refine').each(function() {
        $(this).find('.toggle-content').hide();
    });
    
    // When a toggle is clicked (activated) show their content
    $('.toggle .toggle-trigger').click(function() {
        var el = $(this),
            parent = el.closest('.toggle');

        if (el.hasClass('active')) {
            parent.find('.toggle-content').slideToggle();
            el.removeClass('active');
        } else {
            parent.find('.toggle-content').slideToggle();
            el.addClass('active');
        }
        return false;
    });

    $('.nav-drop a').click(function(e) {
        $('nav').toggle();
        e.preventDefault();
        e.stopPropagation();
    });

    if($('#tab-container').length){
	    $('#tab-container').easytabs({
	        animate: true,
	        animationSpeed: 100
	    });
    }
    
    if($('#product-tabs').length){
    	$('#product-tabs').easytabs();
    }
    

    $('ul.sf-menu').superfish({
        animation: {
            opacity: 'show'
        },
        pathLevels: 3, // slide-down effect without fade-in
        delay: 200
        // 1.2 second delay on mouseout
    });
    
    
    $('#menu').metisMenu({
        toggle: false
    });
    
    
    var currentTallest = 0,
        currentRowStart = 0,
        rowDivs = new Array(),
        $el, topPosition = 0;

    if($('.product-list').length){
	    $('.product-list').each(
	        function() {
	
	            $el = $(this);
	            topPostion = $el.position().top;
	
	            if (currentRowStart != topPostion) {
	
	                // we just came to a new row. Set
	                // all the heights on the completed
	                // row
	                for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
	                    rowDivs[currentDiv]
	                        .height(currentTallest);
	                }
	
	                // set the variables for the new row
	                rowDivs.length = 0; // empty the
	                // array
	                currentRowStart = topPostion;
	                currentTallest = $el.height();
	                rowDivs.push($el);
	
	            } else {
	
	                // another div on the current row.
	                // Add it to the list and check if
	                // it's taller
	                rowDivs.push($el);
	                currentTallest = (currentTallest < $el
	                    .height()) ? ($el.height()) : (currentTallest);
	
	            }
	
	            // do the last row
	            for (currentDiv = 0; currentDiv < rowDivs.length; currentDiv++) {
	                rowDivs[currentDiv]
	                    .height(currentTallest);
	            }
	
	    });
    }


});
});
