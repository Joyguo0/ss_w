<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
	<div class="large-3 small-12 columns">
		<% include PublicationSideBar %>
	</div>

	<div class="large-9 columns">
		<h2><a href="$File.link" title="Name" target="_blank">$Title</a></h2>
		
        <% if $AccessIsDenied %>
        
            $Content
            
        <% else %>
        
		    $Abstract
		
		    $Form
		    
	    <% end_if %>
		    
	</div>     
</div>

