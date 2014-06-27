<% if $Children %>
	<% loop $Children %>
		<li <% if Last %> class="end" <% else %>class="$LinkingMode"<% end_if %>>
			<a href="$Link" class="$LinkingMode" title="Go to the $Title.XML page">
				<!-- <span class="arrow">&rarr;</span> -->
				<span class="text">$MenuTitle.XML</span>
			</a>
		</li>
	<% end_loop %>
<% else %>	
    <% loop $Parent %>
        <% loop $Children %>
            <li <% if Last %> class="end" <% else %>class="$LinkingMode"<% end_if %>>
                <a href="$Link" class="$LinkingMode" title="Go to the $Title.XML page">
                    <!-- <span class="arrow">&rarr;</span> -->
                    <span class="text">$MenuTitle.XML</span>
                </a>
            </li>
        <% end_loop %>
    <% end_loop %>
<% end_if %>
