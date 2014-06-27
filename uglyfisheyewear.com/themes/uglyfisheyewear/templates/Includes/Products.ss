<% if $Products %>
    
	<% loop $Products %>
		<% include ProductItem %>
	<% end_loop %>
	
	<span class="ajaxcallback"></span>
	
	<% if $Products.NotLastPage %>
        <div class="large-4 large-offset-4 column float-left center">
	        <a id="showmore" href="$Products.NextLink" class="button">SHOW MORE &raquo;</a>
	    </div>
    <% end_if %>
   
	
<% else %>

	<div class="alert alert-info">
		<% _t('Products.NONE_TO_DISPLAY','Sorry, there are no products to display in this category. We will be adding more products shortly, come back soon!') %>
	</div>

<% end_if %>