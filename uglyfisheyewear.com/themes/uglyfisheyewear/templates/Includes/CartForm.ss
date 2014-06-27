<div class="row">
<% if IncludeFormTag %>
<form $FormAttributes>
<% end_if %>

    <% if Message %>
    <p id="{$FormName}_error" class="message $MessageType">$Message</p>
    <% else %>
    <p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
    <% end_if %>


    <div class="row cart-actions">
        <% if Cart.Items %>
        <% if Actions %>
        <% loop Actions %>
            $Field
        <% end_loop %>
        <% end_if %>
        <% end_if %>

    </div>
    
    
<div class="">
    <table class="cart">
        <thead>
            <tr>
                <th class="text-left">ITEM DESCRIPTION</th>
                <th></th>
                <th class="th-qty"><%t CartForm.QUANTITY 'Quantity' %></th>
                <th></th>
                <th></th>
                <th><%t CartForm.PRICE 'Price' %>($Cart.TotalPrice.Currency)</th>
                <th class="text-right"><%t CartForm.TOTAL 'Total' %>($Cart.TotalPrice.Currency)</th>
            </tr>
        </thead>
        
        <tbody>
            <% if Cart.Items %>

                <% loop Fields %>
                    $FieldHolder
                <% end_loop %>

            <% else %>
                <tr>
                    <td colspan="6">
                        <p class="alert alert-info">
                            <strong class="alert-heading">
                                <%t CartForm.NOTE 'Note:' %>
                            </strong>
                            <%t CartForm.NO_ITEMS_IN_CART 'There are no items in your cart.' %>
                        </p>
                    </td>
                </tr>
            <% end_if %>
        </tbody>
    </table>


</div>

<div class="">

    <div class="large-3 column push-9 no-pad-right">
        <div class="subtotal-box column">
        
            <section class="order-details">
                <div id="cart-loading-js" class="cart-loading">
                    <div>
                        <h4><%t CheckoutFormOrder.LOADING 'Loading...' %></h4>
                    </div>
                </div>
                
                <% include CartFormOrderSummary %>
                
            </section>
        </div>
        
        <div class="large-12 column add-to-cart">
            <a href="$Controller.LoadCheckoutPage.Link" class="button white-button">PROCEED TO CHECKOUT</a>
        </div>
    </div>
    <div class="large-6 column">
        <div class="subtotal-box column">
            <p class="light inline">
                We accept these forms of payemt - <img src="$ThemeDir/images/icon-visa.jpg"><img src="$ThemeDir/images/icon-mastercard.jpg"><img src="$ThemeDir/images/icon-paypal.jpg">
            </p>
        </div>
        
        <% loop CouponFields %>
            $FieldHolder
        <% end_loop %>
    </div>
    
    
    <div class="continue-shopping cart large-3 pull-9 column no-pad-left">
        <a href="$Controller.LoadProductListingPage.Link" class="button white-button">CONTINUE SHOPPING</a>
    </div>
</div>



    
<% if IncludeFormTag %>
</form>
<% end_if %>
</div>