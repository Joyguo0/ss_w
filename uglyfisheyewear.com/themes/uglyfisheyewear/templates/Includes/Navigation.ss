<ul class="sf-menu">
    <% loop $Menu(1) %>
		<li class="<% if $Children %>has-drop-down<% end_if %>" >
		<a href="$Link" title="Go to the $Title.XML page">$MenuTitle.XML</a>
		<% if $Children %>
			<ul  class="single-drop-down">
				<% include Recursive %>
			</ul>
		<% end_if %>
		</li>
	<% end_loop %>
</ul>    
