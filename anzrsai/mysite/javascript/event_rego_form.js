$(document).ready(function(){
	$('input[name=action_prev]').click(function(){
		$('input').each(function(){
			$(this).attr('aria-required', false);
			$(this).attr('required', false);
		});
	});
	
	$('input.ticket-quantity').change(function(){
		var QTYval = $(this).val();
		QTYval = parseInt(QTYval);
		
		var ForInput = $('.' + $(this).attr('for'));
		
		if(QTYval && QTYval > 0){
			$(this).val(QTYval);
			$(this).attr('aria-required', true);
			$(this).attr('required', true);
			
			ForInput.prop('checked', true);
		}else{
			$(this).val(null);
			
			$(this).attr('aria-required', false);
			$(this).attr('required', false);
			
			ForInput.prop('checked', false);
		}
	});
	
	
	
	//for step two.
	//add require attr to number input field according to which radio or check box user click.
	$('input.qtycheck').click(function(){
		var ThisQTYname = $(this).attr('name') + '-' + $(this).attr('value') + '-QTY';
		
		var ThisTable = $(this).first().parents('table');
		
		//if this is a radio button, check all it's input fields.
		if($(this).attr('type') == 'radio'){
			var ThisNumberFields = ThisTable.find('input[type=number]');
			
			if(ThisNumberFields.length){
			ThisNumberFields.each(function(){
				if($(this).attr('name') == ThisQTYname){
					$(this).attr('aria-required', true);
					$(this).attr('required', true);
				}else{
					$(this).attr('aria-required', false);
					$(this).attr('required', false);
				}
			});
			}
		}
		
		//if this is a checkbox button, added require attr to number field if it's checked
		ThisQTYname = ThisQTYname.replace('[', '');
		ThisQTYname = ThisQTYname.replace(']', '');
		
		
		
		if($(this).attr('type') == 'checkbox'){
			var NumberField = ThisTable.find('input[name="' + ThisQTYname + '"]');
			
			if( ! NumberField.length){
				NumberField = ThisTable.find('.HFTickets-QTY-' + $(this).attr('value'));
			}
			
			if(NumberField.length){
				if($(this).is(':checked')){
					NumberField.attr('aria-required', true);
					NumberField.attr('required', true);
					NumberField.attr('value', 1);
				}else{
					NumberField.attr('aria-required', false);
					NumberField.attr('required', false);
					NumberField.attr('value', null);
				}
			}
		}
	});
	
	
});