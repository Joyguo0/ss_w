<% if $Slideshows %>
	<div class="col12">
	    <!-- Slider -->
	    <div class="flexslider">
	        <ul class="slides">
	        	<% loop $Slideshows %>
		            <li>
		                <img src="$Image.CroppedImage(1140,384).URL" alt="$Title1" title="$Title1" />
		                <div class="flex-caption">
		                	<h3>$Title1</h3>
		                    <h5>$Title2</h5>
		                    <a class="cap-go" href="$Link.LinkURL" title="$Link.Title" $Link.TargetAttr></a>
		                    <div class="fold"></div>
		                </div>
		            </li>
	        	<% end_loop %>
	        </ul>
	    </div>
	    <!-- End Slider -->
	            
	</div>
	<div class="clear"></div>
<% end_if %>