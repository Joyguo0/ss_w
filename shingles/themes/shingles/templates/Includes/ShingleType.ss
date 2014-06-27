<ul class="shingletypes">
	<li class="head"><h5>Shingle Types:</h5></li>
		<% loop $GetShingleHolderPage(9) %>
			
			<li><a title="$Title" href="$Link">$Title</a></li>
			
		<% end_loop%>
</ul>