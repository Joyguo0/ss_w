var returnVAL 	= false;
var form 		= jQuery('#JoinClubMultiForm_JoinClubMultiForm');
var canSubmit 	= false;
var backButton 	= false;
var runOnce 	= false;

function GETbaseHref() {
	var baseTags = document.getElementsByTagName('base');
	if(baseTags) return baseTags[0].href;
	else return "";
}


//alert(jQuery('#PaymentMultiForm_Form_accessCode').val());

var action = jQuery('#PaymentMultiForm_Form').attr('action', jQuery('#PaymentMultiForm_Form_FormActionURL').val());


jQuery(function($) {
	
	//jQuery('#JoinClubMultiForm_JoinClubMultiForm_action_prev').addClass('cancel');


	//dont do validation when clicking 'Back'
	jQuery('#PaymentMultiForm_Form_action_next').click(function(){
		jQuery('#PaymentMultiForm_Form').attr('action', jQuery('#PaymentMultiForm_Form_FormActionURL').val());
	
	});
	
});