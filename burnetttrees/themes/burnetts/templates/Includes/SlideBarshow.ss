<% if $ClassName == "ProductCategory" || $ClassName == "ServiceCategory" %>

	<ul class="sidenav">
        <li>$getParentPage.Title</li>
        
        <% if $getParentChildren %>
	        <% loop $getParentChildren %>
	        	
        		<li><a title="$Title" href="{$Link}"  <% if $LinkingMode == 'current' %>class="active"<% end_if %> >$Title</a></li>
			<% end_loop %>
		<% end_if %>
    </ul>
<% else_if $ClassName == "ProductPage" || $ClassName == "ServicePage" %>
	<ul class="sidenav">
        <li>$getGrandparentsPage.Title</li>
        
        <% if $getGrandparentsChildren %>
	        <% loop $getGrandparentsChildren %>
	        	
        		<li><a title="$Title" href="{$Link}"  <% if $isSection %>class="active"<% end_if %> >$Title</a></li>
			<% end_loop %>
		<% end_if %>
    </ul>
    
<% else_if $Children %>

	<ul class="sidenav">
        <li>$MenuTitle.XML</li>
        <!--
        <li><a class="active" href="#">About Us</a></li>
        <li><a href="#">Menu Item</a></li>
        <li><a href="#">Menu Item</a></li>
        $ isSecond 
        -->
        <% loop $Children %>
    		<li><a title="$Title" href="$Link"  <% if $LinkingMode == 'current' %>class="active"<% end_if %> >$Title</a></li>
   		<% end_loop %>
    </ul>
    
<% else_if $getParentPage %>

	<ul class="sidenav">
        <li>$getParentPage.Title</li>
        
        <% if $getParentChildren %>
	        <% loop $getParentChildren %>
	        	
        		<li><a title="$Title" href="$Link"  <% if $LinkingMode == 'current' %>class="active"<% end_if %> >$Title</a></li>
			<% end_loop %>
		<% end_if %>
    </ul>
	
<% end_if %>


<% if $ClassName != 'ProductListPage' && $ClassName != 'ProductCategory' && $ClassName != 'ProductPage' %>
	<ul class="products-sidenav">
	    <li>Our Products</li>
	    
	    <% if $getProducts(9) %>
	        <% loop $getProducts(9) %>
        		<li><a title="$Title" href="$Link"  >$Title</a></li>
			<% end_loop %>
		<% end_if %>
		
	</ul> 
<% end_if%>

