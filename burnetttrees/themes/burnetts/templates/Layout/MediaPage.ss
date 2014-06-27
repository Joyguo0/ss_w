
<div class="row">
        <div class="large-12 columns">
            <h1 class="page-title">$Title</h1>
            <% include BreadCrumbs %>
        </div>
</div>
<div class="row">
        <div class="large-3 columns show-for-large-up">
            <!-- -->
            <% include SlideBarshow %>
        </div>
        <div class="large-9 columns">
        
            <div id="gallery" style="clear:both">
            
            	<% if MediaOrImages %>
		        	<% loop MediaOrImages %>
			            <div class="item item-image">
		                    <a href="#"></a>
		                    <img src="assets/img/bricks.jpg">
		                    <h5>Image</h5>
		                    <div class="date">$Date</div>
		                    $Content
		                </div>
		                
		        	<% end_loop %>
		        	<div class="clear"></div>
				<% end_if %>
            	
            </div>
            
            
        </div>
</div>