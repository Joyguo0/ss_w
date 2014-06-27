;(function($) { 
	$.entwine('isws', function($){

		$('.cart-form').entwine({

			onmatch : function() {
				var self = this;

				this.updateCart();
				this.on('submit', function(e){
					self._indicateProcessing(e);
				});

				this._super();
			},

			onunmatch: function() {
				this._super();
			},

			updateCart: function() {
				var self = this;
				var values = this.serialize();
				
				$.ajax({
					url: window.location.pathname + '/CartForm/update',
					type: 'POST',
					data: values,
					beforeSend: function() {
						$('#body-content').addClass('loading-currently');
					},
					success: function(data){
						$('.cartpage').replaceWith(data);
					},
					complete: function() {
						$('#body-content').removeClass('loading-currently');
					}
				});
			},

			_indicateProcessing: function(e) {

//				$('input[name="action_process"]', this).attr('value', 'Processing...');
//				$('.Actions .loading', this).show();
			}
			
		});

	});
})(jQuery);