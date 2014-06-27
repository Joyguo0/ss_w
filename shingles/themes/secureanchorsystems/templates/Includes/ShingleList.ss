<div class="product-listing <% if MultipleOf(2) %>second<% end_if %>">
	<div class="pl">
	    <div class="product-image">
	       <!--  <img src="$ThemeDir/images/example3.jpg" alt="#" title="#" /> -->
	       	$Photo.setSize(300,225)
	        <div class="product-overlay">
	            <a href="$Link" title="Read More &raquo;">Read More &raquo;</a>
	        </div>
	    </div>
	    <div class="product-content">
	        <h3><a href="$Link" title="Name">$Title</a></h3>
	        <p>$Content.LimitCharacters(180)</p>
	        <a href="$Link" class="readmore" title="#">Read More &raquo;</a>
	    </div>
	    <div class="clear"></div>
	</div>
</div>