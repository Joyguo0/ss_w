<% if IncludeFormTag %>
<form $FormAttributes>
<% end_if %>



	<% if Message %>
		<p id="{$FormName}_error" class="message $MessageType">$Message</p>
	<% else %>
		<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
	<% end_if %>

	<fieldset>


		<% include OrderFormStep1 %>
		
		
		
        <% include OrderFormStep2 %>
	 

        <% include OrderFormStep3 %>
        
        
        <% include OrderFormStep4 %>
	   
	   
        <% include OrderFormStep5 %>


        <div class="clear" />
	</fieldset>

	
	<% if Cart.Items %>
    <% if Actions %>
        <div class="Actions">
            <div class="loading">
                <img src="swipestripe/images/loading.gif" />
            </div>
            <% loop Actions %>
                $Field
            <% end_loop %>
        </div>
    <% end_if %>
    <% end_if %>
	
	
<% if IncludeFormTag %>
</form>
<% end_if %>