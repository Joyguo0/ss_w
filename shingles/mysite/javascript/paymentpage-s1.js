var BackPackPrice = 0;
var AmountDOM = 0;

;jQuery(function($) {
	
	$(document).ready(function(){
		
		$('#PaymentMultiForm_PaymentMultiForm').validate({
			rules: {
				Amount: {
			        required: true,
			        minlength: 1
			    }
			}
		});
		
		AmountDOM = $('.item-summary .st .amount');
		BackPackPrice = AmountDOM.attr('data-price');
		
		$('#Amount input.text').change(function(){
			var number = parseInt($(this).val());
			
			if(number > 0){
				AmountDOM.html(number);
				$('.st-price .price').html(number * BackPackPrice);
			}else{
				AmountDOM.html('0');
				$('.st-price .price').html('0');
			}
		});
		
	});
	
}); 