<!-- Sidebar Navigation -->
<% if $Menu(2) %>
<div class="sidebarnav">
	<% with $Level(1) %>
		<h5>
			<a href='$Link'>$MenuTitle</a>
		</h5>
		<ul>
			<% include SidebarMenuC %>
		</ul>
	<% end_with %>
</div>
<% end_if %>