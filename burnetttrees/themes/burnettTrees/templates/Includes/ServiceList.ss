<% if $IsRowBegin %>
	<div class="large-4 small-6 columns ">
<% end_if %>

        <div class="product">
            <a href="$Link"></a>
            $Logo.setSize(255,180)
            <h5>$Title</h5>
            <p>$Introductory.LimitCharacters(100)</p>
        </div>
<% if $IsRowEnd %>
	</div>
<% end_if %>   