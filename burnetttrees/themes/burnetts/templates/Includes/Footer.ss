<footer>
    <div class="row">
        <div class="large-2 columns center">
            <div class="footer-logo">
                <a href="/">$SiteConfig.Logo</a>
            </div>
        
            <small>$SiteConfig.FooterBottomContent1.NoHTML</small>
            
            <div class="social-footer">
				<% if $SiteConfig.FooterLinks %>
						<% loop $SiteConfig.FooterLinks %>
						    <a href="$redirectionLink" class="button radius social-footer-btn {$LinkClass}" $TargetAttr><i class="fa fa-{$LinkClass}"></i></a>
						<% end_loop %>
				<% end_if %>
            </div>
        </div>
        
        <div class="large-2 columns">
           $SiteConfig.FooterQuickLinks1
        </div>
        
        <div class="large-2 columns">
            $SiteConfig.FooterQuickLinks2
        </div>
        
        <div class="large-3 columns">
            <div class="footer-map">
            	
                <script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
                <div id="gmap_canvas_footer" style="height:125px; width:100%;"></div>
                <style type="text/css" media="screen">
                	.gm-style img{max-width:none; !important; background:none !important;}.gm-style-iw span {height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;}.gm-style-iw strong {font-weight:400;}.map-data{ position:absolute;top:-1668px;}.gm-style-iw{ height:auto !important;color:#000000; display:block;white-space:nowrap; width:auto !important;line-height:18px; overflow:hidden !important;}
                </style>
                <script type="text/javascript">
                	function init_map(){ 
                		var myOptions={
                			zoom:17, 
                			center: new google.maps.LatLng ($SiteConfig.getCoordinateLat($SiteConfig.Address),$SiteConfig.getCoordinateLng($SiteConfig.Address)),
                			mapTypeId: google.maps.MapTypeId.ROADMAP, disableDefaultUI: true
                		}; 
            			map = new google.maps.Map (document.getElementById("gmap_canvas_footer"), myOptions); 
            			marker = new google.maps.Marker({map: map, position: new google.maps.LatLng ($SiteConfig.getCoordinateLat($SiteConfig.Address),$SiteConfig.getCoordinateLng($SiteConfig.Address))}); 
            			infowindow = new google.maps.InfoWindow ({content:"<span style='height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;'>$SiteConfig.Address</span>" });
            			google.maps.event.addListener (marker, "click", function(){ infowindow.open(map,marker);}); 
                	} 
                	google.maps.event.addDomListener (window, "load", init_map);
                </script>
               
                
            </div>
           
            $SiteConfig.FooterBottomContent2
        </div>
        
        <div class="large-3 columns">
            <div class="footer-tree-care">
                <!-- <a href="111"></a> -->
        		<a href="http://$OtherSiteDomain" title="$OtherSiteConfig.Title">$OtherSiteConfig.itle</a>
        		
                <div class="inner">
                    $SiteConfig.FooterBottomContent3
                </div>
                <div class="red-gradient btrees-link">Go to $OtherSiteConfig.Title &raquo;</div>
            </div>
        </div>        
    </div>
  </footer>
  
