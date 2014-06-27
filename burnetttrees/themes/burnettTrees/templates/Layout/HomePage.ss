 <div class="hero row">
 	<% loop LoadSlides %>
	    <div class="hero-text large-5 columns">
	    	
		        <h2>$Title</h2>
		        $Content
			
	    </div>
	    <div class="large-7 columns">
	        $Image.SetHeight(430)
	    </div>
    
    <% end_loop %>
</div>

  <div class="row">
    <div class="large-4 columns">
        <h3 style="color:#b70000">Take a look at our Products</h3>
        <p>Delenit augue duis dolore te feugait tempor cum soluta nobis option:</p>
        <dl class="accordion" data-accordion>
			<% if $getCategory %>
          	<% loop $getCategory %>
          		<dd>
		            <a class="cat" href="#panel$Pos">$Title</a>
		            <div id="panel$Pos" class="content">
		            	<% loop $Children %>
		          			<a href="$Link">$Title</a>
		          		<% end_loop %>
						
		            </div>
	          	</dd>
          		
          	<% end_loop %>
          	<% end_if %>
        </dl>
        
        
        <div class="row" style="margin-bottom:40px;"><div class="large-12 columns"><a class="cta-home-btn main-btn button tiny radius">ORDER NOW</a><a class="cta-home-btn main-btn button tiny radius">GET A QUOTE</a></div></div>
    </div>
    
    <div class="large-8 columns">
        <div class="products-slider">
            <% loop $getProducts(4) %>
            
            	<div class="product-slider">
	                <div class="product-inner">
	                    $Logo.setSize(255,180)
	                    <div class="product-desc">
	                        <span class="product-category">$CategoryTitle</span>
	                        <h4>$Title</h4>
	                        $Introductory.LimitCharacters(100)
	                        <a class="main-btn button tiny radius" href="$Link">Read More</a>
	                    </div>  
	                </div>
	            </div>
	            
            <% end_loop %>
            
        </div>
    </div>
  
    </div>
    
    <div class="row map-wrapper">
        <div class="large-4 columns map">
            <div class="triangle-left show-for-large-up"></div>
            <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
            <div id="gmap_canvas" style="height:325px; width:100%;"></div>
            <style type="text/css" media="screen">
            	.gm-style img{max-width:none; !important; background:none !important;}.gm-style-iw span {height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;}.gm-style-iw strong {font-weight:400;}.map-data{ position:absolute;top:-1668px;}.gm-style-iw{ height:auto !important;color:#000000; display:block;white-space:nowrap; width:auto !important;line-height:18px; overflow:hidden !important;}
            </style>
            <script type="text/javascript">
	            function init_map(){ 
	            	var myOptions={
	            		zoom:18, 
	            		center: new google.maps.LatLng ($SiteConfig.getCoordinateLat($SiteConfig.Address),$SiteConfig.getCoordinateLng($SiteConfig.Address)), 
	            		mapTypeId: google.maps.MapTypeId.ROADMAP, disableDefaultUI: true
	            	}; 
	            	map1 = new google.maps.Map (document.getElementById("gmap_canvas"), myOptions);
	            	marker1 = new google.maps.Marker({map: map1, position: new google.maps.LatLng ($SiteConfig.getCoordinateLat($SiteConfig.Address),$SiteConfig.getCoordinateLng($SiteConfig.Address))});
	            	infowindow = new google.maps.InfoWindow ({content:"<span style='height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;'>$SiteConfig.Address</span>" }); 
	            	google.maps.event.addListener (marker1, "click", function(){ infowindow.open(map1,marker1);}); 
	            	infowindow.open(map1,marker1);
	            } 
            	google.maps.event.addDomListener (window, "load", init_map);
            </script>
        </div>
        <div class="large-8 columns location">
            <div class="large-5 columns">
                <h3>Put a tagline here, whatever you like</h3>
                <p>80 Barney St, Kiama NSW 2533<br>Open 7am to 4:30pm weekdays, 7am to 12:30pm Saturdays</p>
                <h4>Call us on 02 4233 1311</h4>
            </div>
            <div class="large-7 columns">
                <img src="themes/burnetts/images/trucks.png">
            </div>
        </div>
    </div>