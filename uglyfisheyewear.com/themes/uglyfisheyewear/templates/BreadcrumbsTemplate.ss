<% if $Pages %>
	<% loop $Pages %>
		<li  <% if $Last %>class="current"<% end_if %>><a href="$Link">$MenuTitle.XML</a></li>
	<% end_loop %>
<% end_if %>
