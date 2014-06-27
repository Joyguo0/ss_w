<% if $Children %>
<% loop $Children %>
<li>
    <a href="$Link" class="" title="Go to the $Title.XML page">$MenuTitle.XML</a>

</li>
<% end_loop %>
<% end_if %>
