<!-- checkout step 4 -->
<div class="large-12 column toggle">                            
    <li class="toggle-trigger">
        <div class="step-title">
            <h2>4/ Payment Information</h2>
        </div>
    </li>     
    
    <div id="checkout-step-payment" class="toggle-content column">
        <div class="large-12 inner column inline uppercase no-pad-right"> 
            <div class="large-12 column">
                <div class="shipping-box column">
 
                    <section class="payment-details">
                        <% loop PaymentFields %>
                            $FieldHolder
                        <% end_loop %>
                    </section>
                    
                </div>
            </div>                
        </div>
    </div>
</div>