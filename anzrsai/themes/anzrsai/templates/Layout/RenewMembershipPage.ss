<% include Slideshow %>
<% include BreadCrumbs %>   

<div class="row" id="content">
	<div class="large-10 large-offset-1 column">
	<h2>$Title</h2>
		$Content
		
		$RenewMembershipMultiForm
		
		<% include ResourcesBox %>
	</div>
	
	<script>
		//var testval = jQuery('#ConferenceMultiForm_ConferenceMultiForm_Package').val();
		//alert(testval);
		
		var TypeValue = $("input[name='MembershipType']").val();
		jQuery('#RenewMembershipMultiForm_RenewMembershipMultiForm_MembershipType_'+TypeValue).attr('checked', 'true');
		
		$("input[name='MembershipType']").change(function(){
			
			var SelectValue = $("input[name='MembershipType']:checked").val();		
			var ajaxlink = $("#RenewMembershipMultiForm_RenewMembershipMultiForm_DataLink").val();
			var typeid = $(this).val();
			
			
			
			var showmoreDOM = $(this);
			$.ajax({
				   url: ajaxlink + "getTypePrice?typeid=" + $(this).val(),
				   timeout: 5000,
				   type: "GET",
				   dataType: "json",
				   success: function(response) {
					   if(response.html){
						   
						   jQuery('#Price').html("$ "+ response.html +" inc GST");
						   $("#RenewMembershipMultiForm_RenewMembershipMultiForm_Amount").val(response.html);
					   }
				   },
				   error: function(xhr) {
				    console.log(xhr);
				   }
			});
			/*
			*/
		});
		
	</script>
</div>