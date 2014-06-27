<% include SideBar %>
<div class="col12">
	<div class="dark-area">
	
		<div class="col6">
                
	        <img title="Staying @ Keiraview" alt="Staying @ Keiraview" src="$ThemeDir/images/staying.png" class="head-img">
	        <p>$Content</p>
	        <ul class="thumbnails">
	        	<% loop $Gallerys.Limit(4) %>
		             <li><a href="$Image.url()">$Image.setSize(97,64)</a></li>
	        	<% end_loop %>
	        </ul>
	        
	        <div class="clear"></div>
	    </div>
		
		<div class="col6 last">
			<!-- Slideshow -->
            <div class="slider-area">
            	<!-- Slider -->
                <div id="slider" class="zoomflow">
                    <div class="items">
                    	<% loop $Slideshows %>
		                      <div class="item-tobe" data-source="$Image.url()"></div>
			        	<% end_loop %>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>	
		<div class="clear"></div>
	</div>
	<% include LightArea %>
</div>
<div class="clear"></div>