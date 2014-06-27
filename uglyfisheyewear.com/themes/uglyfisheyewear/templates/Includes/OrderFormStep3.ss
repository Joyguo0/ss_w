<!-- checkout step 3 -->
<div class="large-12 column toggle">                            
    <li class="toggle-trigger">
        <div class="step-title">
            <h2>3/ Shipping</h2>
        </div>
    </li>     
    
    <div id="checkout-step-shipping" class="toggle-content column">
        <div class="large-12 inner column inline uppercase no-pad-right">
        
            <section class="address">
                <div id="address-shipping">
                    <% loop ShippingAddressFields %>
                        $FieldHolder
                    <% end_loop %>
                </div>
            </section>
            
            <input type="submit" value="continue" class="button">   
        </div>
    </div>
</div>

