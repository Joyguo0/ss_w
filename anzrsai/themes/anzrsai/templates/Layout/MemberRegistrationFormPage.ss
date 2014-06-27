<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
	<div class="large-12 columns">
	
        <h2>$Title</h2>
		
		$Content
		
		<% if $MemberRegistrationMultiForm %>
            $MemberRegistrationMultiForm
		<% end_if %>
		
	</div>
</div>

