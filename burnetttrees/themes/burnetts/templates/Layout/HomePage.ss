<div class="hero row">
    
    <div class="large-12 columns">
    	
    	<div class="slideshow">
	    
	        <div class="flexslider">
		        <ul class="slides">
		        	<% loop $LoadSlides %>
			            <li>
			                <img src="$Image.CroppedImage(1138,430).URL" alt="$Title1" title="$Title1" />
			            </li>
		        	<% end_loop %>
		        </ul>
		    </div>
		    
		    <div class="hero-text">
	    	
		        <h2>$Title</h2>
		        
		        $Content
		        
	        	<% loop $HomeLinks %>
	            	<a class="cta-home-btn main-btn tiny button radius" href="$Link.LinkURL" $Link.getTargetAttr>$Title</a>
	            <% end_loop %>
	            
		    </div>
	    
	    </div>
	    
    </div>
</div>




<div class="row">
    <div class="large-4 columns">
        <h3 style="color:#b70000">$SideBarTitle</h3>
		$SideBarContent
		
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
        
        
        <div class="row" style="margin-bottom:40px;">
        	<div class="large-12 columns">
				<% if $SidebarLink1 %>
					<% loop $SidebarLink1 %>
					    <a href="$LinkURL" class="cta-home-btn main-btn button tiny radius" $TargetAttr>$Title</a>
					<% end_loop %>
				<% end_if %>
				<% if $SidebarLink2 %>
					<% loop $SidebarLink2 %>
					    <a href="$LinkURL" class="cta-home-btn main-btn button tiny radius" $TargetAttr>$Title</a>
					<% end_loop %>
				<% end_if %>
        	</div>
        </div>
    </div>
    
    <div class="large-8 columns">
        <div class="products-slider">
            <% loop $getProducts(20) %>
            
            	<div class="product-slider">
	                <div class="product-inner">
	                    $Logo.setSize(255,180)
	                    <div class="product-desc">
	                        <span class="product-category">$CategoryTitle</span>
	                        <h4><a href="$Link" title="$Title">$Title</a></h4>
	                        <p>$Introductory.LimitCharacters(70)</p>
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
                
                $MapArea
                
            </div>
            
            <% if $MapAreaImage %>
                <div class="large-7 columns" style="position: static;">
                    $MapAreaImage
                </div>
            <% end_if %>
        </div>
    </div>