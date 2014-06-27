<div $AttributesHTML <% if DisplayLogic %>data-display-logic-masters="$DisplayLogicMasters"<% end_if %>>
	<h$HeadingLevel><a href="#">$Title</a></h$HeadingLevel>
	<div>
		<% loop $FieldList %>
			$FieldHolder
		<% end_loop %>
	</div>
	<% if DisplayLogic %>
	<div class="display-logic-eval">$DisplayLogic</div>
	<% end_if %>
</div>
