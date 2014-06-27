<!-- responsive nav-->  
    <a id="simple-menu" class="responsive-nav" href="#sidr"></a>
     <div id="sidr" class="sidr">
        <ul>
        	<% loop Menu(1) %>
            	<li><a href="$Link" <% if LinkingMode == current %> class="active"<% end_if %>>$MenuTitle</a></li>
            <% end_loop %>
        </ul>
    </div>    	
<!-- end responsive nav-->  