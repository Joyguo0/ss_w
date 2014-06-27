<h3 class="event-form-heads">
    Congratulations, your payment has been accepeted. The below confirmation details have been sent to your email account.
</h3>

<h3 class="event-form-heads">Your Details</h3>

$Content

<% if $VPCPayment %>
    <% loop $VPCPayment %>
        <h3 class="event-form-heads">Payment Details</h3>
        
        <div class="large-6 columns">
             <table class="event-details">
                <tbody>
                    <tr>
                        <td class="strong right">Transaction Reference</td>
                        <td class="light">$MerchTxnRef</td>
                    </tr>
                    <tr>
                        <td class="strong right">Transaction Number</td>
                        <td class="light">$TransactionNo</td>
                    </tr>
               </tbody>
             </table>    
        </div>
        
        <div class="large-6 columns">
             <table class="event-details">
                <tbody>
                    <tr>
                        <td class="strong right">Card Type</td>
                        <td class="light">$CardTypeName</td>
                    </tr>
                    <tr>
                        <td class="strong right">Amount</td>
                        <td class="light">$$AmountNice AUD</td>
                    </tr>
               </tbody>
             </table>      
        </div>
    <% end_loop %>        
<% end_if %>

<div class="large-12 columns"> 
    <h3 class="event-form-heads">Membership</h3>

    $TicketContent

</div>

