<% loop News %>
	<div class="row">	   
		<div class="news-bit">
			<a id="news-head" href="$Link">$Title <span id="news-date">$Date.format(F jS Y)</span></a>
			<div class="large-3 columns start">
				<a href="$Link"><img src="$Image.CroppedImage(197,150).URL"></a>
			</div>
			<div class="large-9 columns last">
				<p>$Content.LimitCharacters(100) ... <a href="$Link"> Read More &raquo;</a></p>
			</div>
		</div>
	</div>	
<% end_loop %>

<div class="clear"></div>

<% if MoreEvents %>
	<a href="$MoreLink" class="show-more">Show More...</a>
<% end_if %>

