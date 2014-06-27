
<div class="row">
        <div class="large-12 columns">
            <h1 class="page-title">$Title</h1>
            <% include BreadCrumbs %>
        </div>
</div>
<div class="row">
        <div class="large-3 columns show-for-large-up">
            <!--
            -->
            <% include SlideBarshow %>
        </div>
        <div class="large-9 columns">
            <% if $Introductory %>
	            <div class="article-tag row columns">
	                $Introductory
	            </div>
            <% end_if %>
            <div class="row">
                $Content
               
                <div class="article large-7 columns">
                     $Form
                </div>
                <div class="images large-5 columns">
                	<script type="text/javascript" src="http://maps.google.com/maps/api/js?v=3&sensor=false"></script>
                    <div id="gmap_canvas_form" style="height:200px; width:100%;"></div>
		            <style type="text/css" media="screen">
		            	.gm-style img{max-width:none; !important; background:none !important;}.gm-style-iw span {height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;}.gm-style-iw strong {font-weight:400;}.map-data{ position:absolute;top:-1668px;}.gm-style-iw{ height:auto !important;color:#000000; display:block;white-space:nowrap; width:auto !important;line-height:18px; overflow:hidden !important;}
		            </style>
		            <script type="text/javascript">
			            function init_map_form(){ 
			            	var myOptions={
			            		zoom:18, 
			            		center: new google.maps.LatLng ($SiteConfig.getCoordinateLat($SiteConfig.Address),$SiteConfig.getCoordinateLng($SiteConfig.Address)), 
			            		mapTypeId: google.maps.MapTypeId.ROADMAP, disableDefaultUI: true
			            	}; 
			            	map_form = new google.maps.Map (document.getElementById("gmap_canvas_form"), myOptions);
			            	marker_form = new google.maps.Marker({map: map_form, position: new google.maps.LatLng ($SiteConfig.getCoordinateLat($SiteConfig.Address),$SiteConfig.getCoordinateLng($SiteConfig.Address))});
			            	infowindow = new google.maps.InfoWindow ({content:"<span style='height:auto !important; display:block; white-space:nowrap; overflow:hidden !important;'>$SiteConfig.Address</span>" }); 
			            	google.maps.event.addListener (marker_form, "click", function(){ infowindow.open(map_form,marker_form);}); 
			            	infowindow.open(map_form,marker_form);
			            } 
		            	google.maps.event.addDomListener (window, "load", init_map_form);
		            </script>
		            
                    <div class="contact-info">
                        <h5>Contact Info</h5>
                        <p>80 Barney Street,<br>Kiama NSW 2533</p>
                        <p>Open 7am-4:30pm weekdays, 7am-12:30pm Sturdays</p>
                        <p><strong><i class="fa fa-phone"></i> (02) 4233 1311<br><i class="fa fa-envelope"></i> <a href="mailto:info@burnetttrees.com.au">info@burnetttrees.com.au</a></strong></p>
                    </div>
                </div>                
            </div>
        </div>
</div>


