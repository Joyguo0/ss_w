;jQuery(function($) {
  $('#advanced').click(function() {
	var me=$(this);
	if(me.hasClass('advanced-opened')) {
		$('#advanced-options').fadeOut();
		$('#advanced-options-wrapper').slideUp();
		me.html('+ Advanced Search');
	}
	else {
		$('#advanced-options-wrapper').slideDown();
		$('#advanced-options').fadeIn();
		me.html('- Basic Search');
	}
	me.toggleClass('advanced-opened');
  });
});