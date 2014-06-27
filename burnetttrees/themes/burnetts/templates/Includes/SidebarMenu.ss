<ul class="sidenav">
    <li>$MenuTitle.XML</li>
	<li><a title="$Title" href="{$Link}CategorySearch/News"  	<% if $Type == 'News' %>class="active"<% end_if %> >News</a></li>
	<li><a title="$Title" href="{$Link}CategorySearch/Images"  	<% if $Type == 'Images' %>class="active"<% end_if %> >Images</a></li>
	<li><a title="$Title" href="{$Link}CategorySearch/Videos"  	<% if $Type == 'Videos' %>class="active"<% end_if %> >Videos</a></li>
</ul>

<ul class="products-sidenav">
    <li>Our Products</li>
    
    <% if $getProducts(9) %>
        <% loop $getProducts(9) %>
    		<li><a title="$Title" href="$Link"  >$Title</a></li>
		<% end_loop %>
	<% end_if %>
	
</ul>