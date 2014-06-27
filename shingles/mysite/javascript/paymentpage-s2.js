
;jQuery(function($) {
	
	
	function SelectedDelivery(){
		$('.addr-box input').each(function(){
			$(this).attr('aria-required', true);
			$(this).attr('required', true);
		});
	}
	
	function SelectedPickup(){
		$('.addr-box input').each(function(){
			$(this).attr('aria-required', false);
			$(this).attr('required', false);
		});
	}
	
	$(document).ready(function(){
		var checkval = $('input[name=Option]:checked').val();
		
		if(checkval == 'Delivery'){
			$('.addr-box').show();
			SelectedDelivery();
			$('.pickup-box').hide();
		}else if(checkval == 'Pickup'){
			$('.addr-box').hide();
			$('.pickup-box').show();
			SelectedPickup();
		}else{
			$('.addr-box').hide();
			$('.pickup-box').hide();
		}
		
		$('input[name=Option]').click(function(){
			if($('input[name=Option]:checked').val() == 'Delivery'){
				$('.addr-box').show();
				SelectedDelivery();
				$('.pickup-box').hide();
			}else{
				$('.addr-box').hide();
				$('.pickup-box').show();
				SelectedPickup();
			}
		});
		
		
		
		
		
		
		
		
//		paymentForm.validate({
//			rules: {
//				EWAY_CARDNAME: {
//			        required: true
//			    },
//			    EWAY_CARDNUMBER: {
//			    	required: true,
//			        minlength: 16
//			    },
//			    EWAY_CARDEXPIRYMONTH: {
//			    	required: true,
//			        minlength: 2
//			    },
//			    EWAY_CARDEXPIRYYEAR: {
//			    	required: true,
//			        minlength: 2
//			    },
//			    EWAY_CARDCVN: {
//			    	required: true,
//			        minlength: 3
//			    },
//			    Terms: {
//			        required: true
//			    }
//			}
//		});
		
	});
	
}); 