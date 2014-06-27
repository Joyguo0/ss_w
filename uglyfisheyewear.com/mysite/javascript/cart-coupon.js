(function($) {
	$(document).ready(function() {
		$('#apply-coupon-js').live('click', function() {
			
			$('#CouponCode .message').removeClass('required').html('');

			$('.cart-form').entwine('isws').updateCart();

			$.ajax({
				url: window.location.pathname + '/checkcoupon',
				type: 'POST',
				data: $('.cart-form').serialize(),
				success: function(data){

					var dataObj = $.parseJSON(data),
						$couponMessageHolder = $('#CouponCode .message');

					$couponMessageHolder.html(dataObj.errorMessage);
					if (dataObj.errorMessage) {
						$couponMessageHolder.addClass('required').removeClass('hide');
					}
					else {
						$couponMessageHolder.removeClass('required').addClass('hide');
					}
					
					$('.cart-form').entwine('isws').updateCart();
				}
			});
		});
	});
	
	$(document).ready(function() {
		$('a[name="remove_a"]').live('click', function() {

			$('.cart-form').entwine('isws').updateCart();
			
			var ID = $(this).attr('data-id');
			var ajaxlink = $(this).attr('data-link');
			
			$.ajax({
				url: ajaxlink + "?ID=" + ID,
				type: 'GET',
				data: $('.cart-form').serialize(),
				success: function(data){
					//CartForm_CartForm
					$('#CartForm_CartForm').replaceWith(data);
					$('.cart-form').entwine('isws').updateCart();
				}
			});
		});
	});
	
	$(document).ready(function() {
		$('a[name="edit_a"]').live('click', function() {
			

			$('.cart-form').entwine('isws').updateCart();

			var ajaxlink = $(this).attr('data-link');
			
			$.ajax({
				url: ajaxlink,
				type: 'POST',
				data: $('.cart-form').serialize(),
				success: function(data){
					$('#CartForm_CartForm').replaceWith(data);
					$('.cart-form').entwine('isws').updateCart();
				}
			});
		});
	});
	
})(jQuery);