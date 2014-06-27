
	<% if $Children %>
		<% loop $Children %>
			<li class="$LinkingMode">
				<a href="$Link" class="" title="Go to the $Title.XML page">$MenuTitle.XML</a>
				<% if $Children %>
					<ul>
						<% include Sidebar %>
					</ul>
				<% end_if %>
			</li>
		<% end_loop %>
	<% end_if %>

