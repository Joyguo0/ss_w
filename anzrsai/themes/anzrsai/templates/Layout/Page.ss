<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">

    <% include SideBar %>

	<div class="<% if $PageBannersSource != "Hide" %>large-9<% else %>large-12<% end_if %> columns">
		<h2>$Title</h2>
		$Content
		$Form
		
		<% include ResourcesBox %>
	</div>     
	
</div>

