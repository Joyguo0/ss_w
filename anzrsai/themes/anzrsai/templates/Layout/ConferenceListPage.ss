<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
	<div class="large-3 small-12 columns">
		<% if $Menu(2) %>
		<ul class="side-nav">
			<% with $Level(1) %>
				<% include SidebarMenu %>                 
			<% end_with %>                  
		</ul>
		<% end_if %>
	
	</div>

	<div class="large-9 columns">
		<h2>$Title</h2>
		$Content
		
		$ConferenceMultiForm
		
		<% include ResourcesBox %>
	</div>
	
	
	<script>
		//var testval = jQuery('#ConferenceMultiForm_ConferenceMultiForm_Package').val();
		//alert(testval);
		var package = $("input[name='Package']").val();
		jQuery('#ConferenceMultiForm_ConferenceMultiForm_Package_'+package).attr('checked', 'true');
		
		var EventTicket = $("input[name='EventTicket']").val();
		jQuery('#ConferenceMultiForm_ConferenceMultiForm_EventTicket_'+EventTicket).attr('checked', 'true');
		//alert(EventTicket);
		
		var SocialEventTickets = $("input[name='SocialEventTicket']").val();
		var SocialEventTicket = '';
		for(var key in SocialEventTickets)
		{
			//alert(SocialEventTickets[key]);
		}
		//alert(SocialEventTickets);
		jQuery('#ConferenceMultiForm_ConferenceMultiForm_SocialEventTicket_'+SocialEventTicket).attr('checked', 'true');
		
	</script>
</div>

