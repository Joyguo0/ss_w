
		<% loop $Menu(1) %>
			<li>
			<a href="$Link" class="sf-menu sf-js-enabled <% if $Children %>sf-arrows<% end_if %>" title="Go to the $Title.XML page">$MenuTitle.XML</a>
			<% if $Children %>
				<ul  class="drop">
					<% include SideBar %>
				</ul>
			<% end_if %>
			</li>
		<% end_loop %>

