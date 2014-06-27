<% if $Slideshows %>
	<div class="top-slider">
	    <div class="onepcssgrid-1140">
	    
		    	<div class="col8">
		        	<div class="top-stuff">	
		        		<!--
		                <h3>High Visibility Backpacks</h3>
		                <p>Curabitur quis tincidunt odio, eget scelerisque sapien. Mauris vehicula lorem a mi semper, eget faucibus sapien gravida. Nam ligula libero, faucibus sed lobortis in, malesuada semper tellus.</p>
		                -->

		                <% loop $Slideshows.Limit(1) %>
		                
					        <h3>$Title1</h3>
		                	<p>$Title2</p>
		                
					    <% end_loop %>
		                
		                <div class="buttons" id="box-links">
		                    <a class="redbutton" href="<% if $getPaymentPage %>$getPaymentPage.Link<% end_if %>">Buy Now</a> <span class="circled">or</span> <a class="redbutton" href="/#enquiry">Make An Enquiry</a>
		                </div>
		            </div>
		        </div>
			
		        <div class="col4 last">
		            <!-- Slider -->
		            <div class="flexslider">
		                <ul class="slides">
		                	<% loop $Slideshows %>
			                    <li>
			                        <img src="$Image.SetRatioSize(360,320).URL" alt="$Title1" title="$Title1" />
			                    </li>
							<% end_loop %>
		                    <!--
		                    <li>
		                        <img alt="Slide" title="Slide" src="$ThemeDir/images/bag.png" />
		                    </li>
		                    -->
		                </ul>
		            </div>
		            <!-- End Slider -->
		        </div>
		        <div class="clear"></div>
	    	
	    </div>
	</div>
<% end_if %>