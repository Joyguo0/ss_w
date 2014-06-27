


<% include Slideshow %>

<!-- Four Area -->
<div class="carousel-area">

	<div class="zig"></div>

    <div class="onepcssgrid-1140">
        
        <!-- Carousel -->
        <div class="col12">
            <h3 class="header"><span>Features</span></h3>
        </div>
        
        <div class="gallery">   
        <% loop $Features %>
		    
		       	<div class="col3 feature-item <% if MultipleOf(2) %>second<% end_if %> <% if MultipleOf(4) %>last<% end_if %>">
					<a class="slide" href="$Image.URL" title="$Title">	
		                <div class="slideimage">
		                    <img src="$Image.CroppedImage(248,200).URL" alt="$Title1" title="$Title1" />
		                    <h5>$Title</h5>
		                </div>
		                <div class="slidetext">
		                    <p>$Content</p>
		                </div>
		            </a>
	        	</div>
	        	
	        	<% if MultipleOf(4) %>
	        	   <div class="clear"></div>
	            <% end_if %>
            
	    <% end_loop %>   
		</div>
        <div class="clear"></div>   
        
    </div>
</div>
<!-- End Four Area -->

<!-- Pricing Area -->
<div class="pricing-area">
    <div class="onepcssgrid-1140">
        
        <div class="col12">
	        <h3 class="header"><span>$TSTitle</span></h3>
        	<p>$TSContent</p>
        </div>
        
        <div class="clear"></div>
        
    </div>
</div>

<!-- Call Area -->
<div class="call-area">
    <div class="onepcssgrid-1140">
        
        <div class="col12">
            <a class="redbutton" href="<% if $getPaymentPage %>$getPaymentPage.Link<% end_if %>" title="Buy Now">Buy Now</a>
        </div>
        
        <div class="clear"></div>
        
    </div>
</div>

<!-- Contact Area -->
<div class="contact-area" id="enquiry">
    <div class="onepcssgrid-1140">
    
    	<div class="col12">
    		<h3 class="contact-header"><span>Contact Us</span></h3>
    	</div>
        
        <div class="col3">
        	$Content
        </div>
        
        <div class="col9 last">
            <% if $Form %>
        	   $Form
        	<% end_if %>   
        	<div class="clear"></div>
        </div>
        
        <div class="clear"></div>
        
    </div>
</div>

