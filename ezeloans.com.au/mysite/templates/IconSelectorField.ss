<ul id="$ID" class="$extraClass">
	<% loop $Options %>
		<li class="$Class feature">
			<input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> />
			<div class="feature-icon $Value">
			 <span></span>
			</div>
		</li>
	<% end_loop %>
</ul>
