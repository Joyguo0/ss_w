
<div class="row">
        <div class="large-12 columns">
            <h1>$Title</h1>
            <% include BreadCrumbs %>
            <hr />
        </div>
</div>
<div class="row">
        <div class="large-3 columns show-for-large-up">
            <!-- -->
            <% include SidebarMenu %>
        </div>
        <div class="large-9 columns">
        
            <div id="gallery" style="clear:both">
            
            	<% if $Medias %>
		        	<% loop $Medias %>
			            <div class="item item-image">
		                    <a href="$Link"></a>
		                    <img src="assets/uploads/bricks.jpg">
		                    <h5>$RedirectionType</h5>
		                    <div class="date">$Created</div>
		                    $Content
		                </div>
		                
		        	<% end_loop %>
		        	<div class="clear"></div>
				<% end_if %>
            	
                
            </div>
            
            
        </div>
</div>