<% if $IncludeFormTag %>
<form $AttributesHTML>
<% end_if %>


	<% if $Message %>
	<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
	<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>
	
	<fieldset>
		<%-- if $Legend %><legend>$Legend</legend><% end_if --%> 
		
		
		<% loop $Fields %>
			<% if $Name == Quantity %>
				<div class="large-4 small-12 column no-pad-left inline bottom-margin-small">
					$Field
				</div>
			<% else_if $hasClass('attribute_option') %>
				<div class="large-8 small-12 column no-pad-right inline">
					$Field
				</div> 
			<% else %>
				$Field
			<% end_if %>
		<% end_loop %>
		
		
		<div class="clear"><!-- --></div>
	</fieldset>

	<% if $Actions %>
	<div class="Actions">
		<% loop $Actions %>
		
		
			<% if $Name == action_add %>
				<div class="add-to-cart large-6 small-12 column no-pad-left bottom-margin-small">
			    	$Field
				</div>
			<% else %>
				$Field
			<% end_if %>
		
			<div class="continue-shopping large-12 small-6 column no-pad-right">
	    		<a href="$Top.Controller.LoadProductListingPage.Link" class="button white-button">
	    			CONTINUE SHOPPING
	    		</a>
			</div> 

		<% end_loop %>
	</div>
	<% end_if %>
	
	
<% if $IncludeFormTag %>
</form>
<% end_if %>

