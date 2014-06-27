<% include BreadCrumbs %>



<div class="basic-content">
	<div class="onepcssgrid-1140">
        
        <div class="col3">
        	
            <% include SlideBarshow %>
            <div class="clear"></div>
            
        </div>
        
        <!-- Content Bit -->
        <div class="col9 last">
        	<% if $Content %>
	        	<div class="content">
	        		$Content
	        	</div>
        	<% end_if %>
        	
        	<% if $ShowShingles %>
    			<% loop $ShowShingles.limit(1000) %>
                	<% include ShingleList %>
    			<% end_loop%>
            <% else %>
                <p>There is no product.</p>
            <% end_if %>    
        </div>
        
        <div class="clear"></div>
        
  </div>
</div>

