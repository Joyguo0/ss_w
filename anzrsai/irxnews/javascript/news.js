(function($) {
	$(function() {

		var fetching = false;
		$(document).on("click", '.show-more',function(e) {
		//$('.show-more').live('click', function(e){
			e.preventDefault();
			var me = $(this);
			
			if(!fetching){
				fetching = true;
				
				me.addClass('loading');
				$.ajax({
					url: me.attr('href'),
					success: function(data) {
						me.remove();
						$('#news-container').append(data);
						fetching = false;
					}
				});
			}
			
		});

	});

})(jQuery);