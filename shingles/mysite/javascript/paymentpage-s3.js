var canSubmit 				= true;

var backButton 				= false;
	
var originalTitle			= $('#original-title');
var donationDiv 			= $('#donation-details');
var detailsForm 			= $('#Form_DetailsForm');
var detailsDiv 				= $('#contact-details');
var continueToPaymentButton = $('#Form_DetailsForm_action_details');
var paymentDiv 				= $('#payment-details');
var paymentForm 			= $('#PaymentMultiForm_PaymentMultiForm');
var paymentButton 			= $('#Form_PaymentForm_action_payment');
var paymentFormMessage 		= $('#payment-form-message');
var paymentStatusText 		= $('#loading-text span');
var successDiv 				= $('#success-details');

var loadingPopUp			= $('#loading-popup');


;jQuery(function($) {
	$(document).ready(function(){
		
		//dont do validation when clicking 'Back'
		$('#PaymentMultiForm_PaymentMultiForm_action_prev').click(function(){
			paymentForm.valid = function(){return true;};
		
			paymentForm.attr('action', $('#PaymentMultiForm_PaymentMultiForm_BackURL').val());
			
			$('.CompositeField.composite.nolabel input').each(function(){
				$(this).attr('disabled','disabled');
			});
			
			$('#PaymentMultiForm_PaymentMultiForm_Terms').attr('disabled','disabled');
			
			backButton = true;
			
		});
		
		$('input#Form_PaymentForm_EWAY_CARDNAME').attr('autocomplete','off');
		$('input#Form_PaymentForm_EWAY_CARDNUMBER').attr('autocomplete','off');
		$('input#Form_PaymentForm_EWAY_CARDEXPIRYMONTH').attr('autocomplete','off');
		$('input#Form_PaymentForm_EWAY_CARDEXPIRYYEAR').attr('autocomplete','off');
		$('input#Form_PaymentForm_EWAY_CARDCVN').attr('autocomplete','off');
	
		
		paymentForm.submit(function() {
			
			if(backButton){
				canSubmit = true;
				return true;
			}
	
			if(!paymentForm.valid()){
				return false;
			}
			
			if (typeof alternatePaymentMethod == 'function') { 
				alternatePaymentMethod(); 
			}else{
				//default eWay Rapid 3.1 API
				processPayment();
			}
			
			return false;
		});
		
		paymentForm.validate({
			rules: {
				EWAY_CARDNAME: {
			        required: true
			    },
			    EWAY_CARDNUMBER: {
			    	required: true,
			        minlength: 16
			    },
			    EWAY_CARDEXPIRYMONTH: {
			    	required: true,
			        minlength: 2
			    },
			    EWAY_CARDEXPIRYYEAR: {
			    	required: true,
			        minlength: 2
			    },
			    EWAY_CARDCVN: {
			    	required: true,
			        minlength: 3
			    },
			    Terms: {
			        required: true
			    }
			}
		});
	});
});



//function for updating member details
function createAccessCode(paymentFieldsShowing){
	if(canSubmit){
		canSubmit = false;
		if(!paymentFieldsShowing){
			continueToPaymentButton.hide();
			continueToPaymentButton.after('<img class="payment-loading"src="irxewayonepageajaxpayment/images/loading-indicator.gif" />');
		}
		
		//submit user's details
		$.ajax({
			url: detailsForm.attr('action'),
			timeout: 30000,
			data: detailsForm.serialize(),
			type: "POST",
			dataType: "json",
			success: function(response) {
				console.log(response);
				if(response.success){
					//success 
					if(response.acarray){

						$('#Form_DetailsForm *').filter(':input').each(function(){
						    $(this).attr('disabled', 'disabled');
						});
						
						detailsForm.show();
						
						if (typeof accessCodeOnSuccess == 'function') { 
							accessCodeOnSuccess(); 
						}
						
						if(response.acarray.FormActionURL){
							$('#Form_PaymentForm_EWAY_ACCESSCODE').val(response.acarray.AccessCode);
						}
						if(response.acarray.FormActionURL){
							paymentForm.attr('action', response.acarray.FormActionURL);
						}
						
						paymentForm.show();
						paymentDiv.show();
					}
					
					return true;
				}else{
					//something is wrong
					if(response.emailfail){
						console.log(response);
						//TODO do something for email.
						///////
						//////
					}
					
					return false;
				}
			},
			error: function(xhr) {
				console.log(xhr);
				return false;
			},
			complete: function(){
				canSubmit = true;
				$('.payment-loading').remove();
				loadingPopUp.hide();
			}
		});
		
	}
}

function processPayment(){
	
	var actionURL = paymentForm.attr('action');
	var accesscode = $('input[name=AccessCode]').val();
	var MultiFormSessionID = $('input[name=MultiFormSessionID]').val();
	detailsForm.hide();
//	paymentForm.hide();
	loadingPopUp.show();

	if(canSubmit){
		canSubmit = false;
		eWAY.process(document.getElementById('PaymentMultiForm_PaymentMultiForm'), {
			autoRedirect: false,
			onComplete: function (data) {
				// this is a callback to hook into when the requests completes
				console.log('The JSONP request has completed');
				console.log(data);

				var RESRedirectUrl = data.RedirectUrl; ////i.e. - https://brisx.com/orderupdate/accheck?AccessCode=A1001UnOixF2jXJna1r9qbNFRjB_unSCseJtYG_MsMUUklxe9fvd7JCxx3_5reB3j1eeLJ_cq63CUWNEaN0D150Grf29vBlbZaWONY60P0ildjoKA4gOsecpBqYvXz4NEwHjR

				paymentStatusText.html('Verifying...');
				
				//we get result form eway, sent to result.php to verify the result
				if(RESRedirectUrl.length > 10){
		            $.ajax({
		                type: 'GET',
		                url: RESRedirectUrl + '&MultiFormSessionID=' + MultiFormSessionID,
		                dataType: 'json',
		                success: function(response){
		                	if(response.result == 'failed'){
		                		window.location.reload();
		                	}else{
			                	//redirect to page according to reponse.
			                	window.location.replace(response.result);
		                	}
		                	
			                //payment success
//		                	if(response.success){
//			                	console.log('result success');
//			                	
//		                		successDiv.append(response.details);
//		                		successDiv.show();
//		                		
//			                	paymentFormMessage.html('Success woop woop');
//			                	paymentFormMessage.show();
//			                	
//			                	originalTitle.remove();
//			                	donationDiv.remove();
//			                	detailsDiv.remove();
//			                	paymentDiv.remove();
//			                	loadingPopUp.hide();
//			                	
//			                }else{
//				                //payment FAILED
//			                	console.log('result false - ' + response.message);
//			                	paymentFormMessage.html(response.message);
//			                	paymentFormMessage.show();
//			                	paymentForm.show();
//			                	detailsForm.show();
//								//re-generate the access code.
//								$('#Form_PaymentForm_EWAY_ACCESSCODE').attr('value', '');
//								canSubmit = true;
//								$('#Form_DetailsForm *').filter(':input').each(function(){
//								    $(this).removeAttr('disabled');
//								});
//								createAccessCode(true);	
//		                	}
			            },
						error: function(xhr) {
							console.log('from eway - error');
							console.log(xhr);
							canSubmit = false;
							paymentFormMessage.html('There is error when processing payment, please try again.');
							paymentFormMessage.show();
							loadingPopUp.hide();
						}
		            });
				}
				
			},
			onError: function (e) {
				// this is a callback you can hook into when an error occurs
				console.log('There was an error processing the request');
				//window.location.replace(urlToRedirectOnError);
			},
			onTimeout: function (e) {
				// this is a callback you can hook into when the request times out
				console.log('The request has timed out');
				//window.location.replace(urlToRedirectOnError);
			}
		});
	}

 
}