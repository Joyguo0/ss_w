<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">
	<h1 class="large-9 column no-pad-left">$Title</h1>
	
	<div class="add-to-cart large-3 small-12 column no-pad-right">
        <a href="$LoadCheckoutPage.Link" class="button white-button">PROCEED TO CHECKOUT</a>
    </div>
</div>



<span class="cartpage isws">  <%-- these span and its class names are compulsory for js. --%>
    $CartForm
</span>



<div class="row">
    <% if $RelativeProducts %>
        <div class="large-12 column carousel relative">
            <h5 class="red">You might also be interested in</h5>
            <ul class="bxslider">
                <% loop $RelativeProducts %>
                    <li>
                        <div class="product-list large-3columns">
                            <a class="product-image" href="$Link">$ProductThumbnail.SetSize(221,147)</a>
                            <a href="$Link">$Title</a>
                            <span class="price">$Product.Price.Nice</span>
                        </div>
                    </li>
                <% end_loop %>        
            </ul>
        </div>
    <% end_if %>
</div>