;jQuery(function($) {
	
//	var TypeValue = $("input[name='MembershipType']").val();
//	jQuery('#MemberRegistrationMultiForm_MemberRegistrationMultiForm_MembershipType_'+TypeValue).attr('checked', 'true');
	
	$("input[name='MembershipType']").change(function(){
		
		var SelectValue = $("input[name='MembershipType']:checked").val();		
		var ajaxlink = $("#MemberRegistrationMultiForm_MemberRegistrationMultiForm_DataLink").val();
		var typeid = $(this).val();
		
		//alert(ajaxlink);
		
		var showmoreDOM = $(this);
		$.ajax({
			   url: ajaxlink + "getTypePrice?typeid=" + $(this).val(),
			   timeout: 5000,
			   type: "GET",
			   dataType: "json",
			   success: function(response) {
				   if(response.html){
					   
					   jQuery('#Price').html(response.html);
					   $("#MemberRegistrationMultiForm_MemberRegistrationMultiForm_Amount").val(response.html);
				   }
			   },
			   error: function(xhr) {
			    console.log(xhr);
			   }
		});
		/*
		*/
	});
	
	
	
	$('#MemberRegistrationMultiForm_MemberRegistrationMultiForm_RegType_NewMember').livequery(function(){
		if($(this).is(':checked')){
			$('.ReturningMember').hide();
		}
	});
	
	$('#MemberRegistrationMultiForm_MemberRegistrationMultiForm_RegType_ReturningMember').livequery(function(){
		if($(this).is(':checked')){
			$('.NewMember').hide();
		}
	});
	
	$('#MemberRegistrationMultiForm_MemberRegistrationMultiForm_RegType_NewMember').livequery('change', function() {
		$('.ReturningMember').hide();
		$('.NewMember').show();
	});
	
	$('#MemberRegistrationMultiForm_MemberRegistrationMultiForm_RegType_ReturningMember').livequery('change', function() {
		$('.ReturningMember').show();
		$('.NewMember').hide();
	});
	
}); 