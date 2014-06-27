<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
	<div class="large-3 small-12 columns">
		<% include PublicationSideBar %>
	</div>

	<div class="large-9 columns">
		<h2 class="chapter-title">$Title</h2>
		
		<% if $AccessIsDenied %>
		
            $Content
            
		<% else %>
    		$Desc
    		
    		<% if $FrontPages %>
                <p><a href="$FrontPages.URL"><b>Front Pages</b></a></p>		
    		<% end_if %>
                    		
        		
    		<% if $Children %>
        		<% loop $Children %>
        		
        		  <% include ChapterItem %>
        	    	
        		<% end_loop %>
        	<% else %>
        	   <p>There is no chapter available for this issue.</p>
        	<% end_if %>	
        	
        	
            <% if $BackPages %>
                <p><a href="$BackPages.URL"><b>Back Pages</b></a></p>      
            <% end_if %>
        		
    		$Form
        <% end_if %>
	</div>     
</div>

