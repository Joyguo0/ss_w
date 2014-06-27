$(document).ready(function(){
    
    $(document).foundation();
    
    //sidr mobile side menu
    $('#sidemenu').sidr({
        name: 'sidr',
        source: 'nav',
        side: 'right'
    });
    
    //home slider
	$('.hero-slider').royalSlider({
		slidesOrientation: 'vertical',
		autoHeight: false,
		arrowsNav: true,
		arrowsNavAutoHide: false,
		fadeinLoadedSlide: false,
		imageScaleMode: 'none',
		imageAlignCenter:false,
		loop: true,
		numImagesToPreload: 6,
		keyboardNavEnabled: true,
		usePreloader: false,
		globalCaption: true,
        autoScaleSlider: false,
		autoScaleSliderWidth: 1460,     
		autoScaleSliderHeight: 500,
		imgWidth: 1460,
		imgHeight: 500
	});
	$('.rsArrow').wrapAll('<div class="arrow-container">');
	$('.arrow-container').wrapAll('<div class="slider-wrap arrows">');
	$('.rsGCaption').wrapAll('<div class="slider-wrap">');
    $('.rsArrowRight').html('<i class="fa fa-chevron-down"></i>');
    $('.rsArrowLeft').html('<i class="fa fa-chevron-up"></i>');
    
    //resize slider and autoplay on mobile
    $( window ).resize(function() { updateSlider(); });
    function updateSlider() {
        var slider = $(".hero-slider").data('royalSlider');
        slider.updateSliderSize();
        slider.updateThumbsSize();
    }
    
    //footer dropdown nav for mobile
    $('.footer-links a').each(function(i){
        var footertext = $(this).text();
        var footerhref = $(this).text();
        $('.footer-mobile select').append("<option value='"+footerhref+"'>"+footertext+"</option>");
    });
     $(".footer-mobile select").change(function(){
        if ($(this).val()!='') {
          window.location.href=$(this).val();
        }
    });
    
});