<div class="product-listing <% if $MultipleOf(2) || $isSecond %>second<% end_if %>">
	<div class="pl">
	    <a href="$Link" title="Name" class="product-image">
	       <!--  <img src="$ThemeDir/images/example3.jpg" alt="#" title="#" /> -->
	       	$Photo.setSize(300,225)
	    </a>
	    <div class="product-content">
	        <h3><a href="$Link" title="Name">$Title</a></h3>
	        <p>$Content.LimitCharacters(180)</p>
	        <a href="$Link" class="readmore" title="#">Read More &raquo;</a>
	    </div>
	    <div class="clear"></div>
	</div>
</div>