<!-- start news -->


<% if MoreEvents %>
	<a href="$MoreLink" class="show-more">Show More...</a>
<% end_if %>


<div class="large-4 columns latest-news">
	<h3>Latest News</h3>
</div>
<% if LatestNews %>
	<% loop LatestNews %>
	<div class="large-4 columns latest-news-bits" <% if $Last %>id="end-news-bit"<% end_if %> >
		<div class="large-4 small-6 columns">
			<a class="news-bit-img" href="$Link"><img alt="$Title" Title="$Title" src="$Image.CroppedImage(115,73).URL">
				$Date.format(j F)
			</a>
		</div>
		<div class="large-8 small-6 columns">
			<h4><a href="$Link">$Title</a></h4>
			<p>$Content.LimitCharacters(100) <a href="$Link">More &raquo;</a></p>
		</div>
	</div>
	<% end_loop %>
<% end_if %>
