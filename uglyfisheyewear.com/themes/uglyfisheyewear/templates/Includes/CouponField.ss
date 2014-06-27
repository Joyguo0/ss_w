<div class="column" id="coupon-box">
    <div id="$Name" class="row collapse field<% if extraClass %> $extraClass<% end_if %>">
        <div class="large-4 column">
            <h5 for="$ID">DISCOUNT COUPON</h5>
        </div>  
         
        <div class="large-5 column light-form">
            <%-- $Field --%>
            <input type="text" name="CouponCode" class="coupon_" id="CartForm_CartForm_CouponCode" placeholder="Enter coupon code">
        </div> 
        
        <div class="large-3 column light-form">
            <input type="button" value="REDEEM &raquo;" id="apply-coupon-js"  class="button mid-button float-right">
        </div>    
        
        <span class="message $MessageType hide">$Message</span>
    </div>  
</div>     