<% if LinkOrSection = section %>
	<% if $Children %>
		<% loop $Children %>
			<% if $ClassName != Category %>
				<li <% if Last %> class="end" <% else %>class="$LinkingMode"<% end_if %>>
				<a href="$Link" class="$LinkingMode" title="Go to the $Title.XML page">
					<span class="arrow">&rarr;</span>
					<span class="text">$MenuTitle.XML</span>
				</a>
				</li>
				<% if $Children %>
					<ul>
						<% include SidePublication %>
					</ul>
				<% end_if %>
			<% end_if %>
		<% end_loop %>
	<% end_if %>
<% end_if %>