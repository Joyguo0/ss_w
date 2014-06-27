<div class="home-main">
    <div class="onepcssgrid-1140">
		<% include Slideshow %>

		
		<div class="col9">
			<div class="content">
				$Content
			</div>
		</div>
		
        
        <div class="col3 last">
        	
            <!-- Banners -->
            <% include SidebarMenu %>
            
            <div class="clear"></div>
            
        </div>
        <div class="clear"></div>
        
        
        <% if $ProductLinks %>
            <!-- Carousel -->
            <div class="col12">
                <h3 class="carousel-header">Our Products</h3>
            </div>
            
            <% loop $ProductLinks %>
	            <div class="<% if $TotalItems = 3 %>col4 <% if MultipleOf(3) %>last<% end_if %><% else %>col3 <% if MultipleOf(4) %>last<% end_if %><% end_if %>">
					<div class="product-links">
						<div class="slide">
							<a class="image" style="background-image: url($Image.URL);" href="$Link.LinkURL" title="$Title"></a>
							<div class="slidetext">
								<h5><a href="$Link.LinkURL" title="$Title">$Title</a></h5>
							</div>
						</div>
					</div>
	    		</div>
    		<% end_loop%>
            <div class="clear"></div>   
            <!--End Carousel (End onerow) -->
        <% end_if %>


	</div>
</div>