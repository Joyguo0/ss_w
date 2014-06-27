<% if $IncludeFormTag %>
	<form $AttributesHTML>
<% end_if %>
	

	<% if $Actions %>
		<div class="Actions">
			<% loop $Actions %>
				$Field
			<% end_loop %>
		</div>
	<% end_if %>
<% if $IncludeFormTag %>
	</form>
<% end_if %>
