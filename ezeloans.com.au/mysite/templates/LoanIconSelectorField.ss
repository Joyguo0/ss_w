<ul id="$ID" class="$extraClass loans-horiz-area">
	<% loop $Options %>
		<li class="$Class feature">
			<input id="$ID" class="radio" name="$Name" type="radio" value="$Value"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> />
           
            <a class="loans-horiz" href="javascript:void(0)">
                <div class="$Value"></div>
            </a>
		</li>
	<% end_loop %>
</ul>
