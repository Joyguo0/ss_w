<%--Include SidebarMenu recursively --%>
<% if LinkOrSection = section %>
	<% if $Children %>
		<% loop $Children %>
			<li class="$LinkingMode">
				<a href="$Link" class="<% if $LinkingMode == current %> active<% end_if %><% if $Children %> withchildren<% end_if %>" title="Go to the $Title.XML page">
					<span class="text">$MenuTitle.XML</span>
				</a>

				<% if $Children %>
					<ul>
						<% include SidebarMenuC %>
					</ul>
				<% end_if %>

			</li>
		<% end_loop %>
	<% end_if %>
<% end_if %>
