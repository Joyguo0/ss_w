<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
	<div class="large-3 small-12 columns">
        <% include PublicationSideBar %>
	</div>

	<div class="large-9 columns">
		<h2>$Title</h2>
		$Content
		
		<!--  input the sub page (5) -->
		<% if not $Children %>
    		<p>There is no issue available for this volume.</p>
		<% end_if%>
		<!--  end the sub page (5) -->
		
		$Form
	</div>     
</div>

