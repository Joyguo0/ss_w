<!-- start main nav-->  
  <nav class="horizontal-nav">
    <ul class="menu">
    	<% loop Menu(1) %>
        	<li><a href="$Link" class="$LinkingMode<% if LinkingMode == current %> active<% end_if %>">$MenuTitle</a></li>
        <% end_loop %>
    </ul>
</nav>
<!-- end main nav-->