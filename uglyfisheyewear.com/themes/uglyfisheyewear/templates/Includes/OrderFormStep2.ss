<!-- checkout step 2 -->
<div class="large-12 column toggle">                            
    <li class="toggle-trigger">
        <div class="step-title">
            <h2>2/ Your Details</h2>
        </div>
    </li> 
        
    <div id="checkout-step-details" class="toggle-content column">
        <div class="large-12 inner column inline uppercase no-pad-right">
        

            <section class="address">
                <div id="address-billing">
                    <% loop BillingAddressFields %>
                        $FieldHolder
                    <% end_loop %>
                </div>
            </section>
            
            <input type="submit" value="continue" class="button">   
        </div>
    </div>
</div>

