<!-- checkout step 5 -->
<div class="large-12 column toggle">                            
    <li class="toggle-trigger">
        <div class="step-title">
            <h2>5/ Order Review</h2>
        </div>
    </li>     
    
    <div id="checkout-step-review" class="toggle-content column">
        <div class="large-12 column">  


                <section class="order-details">
                    <h3><%t CheckoutFormOrder.YOUR_ORDER 'Your Order' %></h3>
        
                    <div id="cart-loading-js" class="cart-loading">
                        <div>
                            <h4><%t CheckoutFormOrder.LOADING 'Loading...' %></h4>
                        </div>
                    </div>
                    
                    <% include OrderFormCart %>
                </section>

        </div>
    </div>
</div>