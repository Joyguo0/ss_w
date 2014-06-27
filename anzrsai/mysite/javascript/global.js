;jQuery(function($) {
	
	 $(document).ready(function(){
		  $('.horizontal-nav').horizontalNav({
			responsive: true,
			tableDisplay: true
		  });
		  
		  $('#simple-menu').sidr();
//		  
//		  document.write('<script src=themes/anzrsai/javascript/vendor/'
//				    + ('__proto__' in {} ? 'zepto' : 'jquery')
//				    + '.js><\/script>');
		  
		  
		  $(document).foundation('orbit', {
			  orbit_transition_class: 'my-transition'
		  });
		  
		  $(document).foundation();
		  
		  $.each($('.footer-links a'),function(){
			 $('#footer-links-drop').append('<option value="'+$(this).attr('href')+'">'+$(this).text()+'</option>');
		  });
		  
	});
	
}); 