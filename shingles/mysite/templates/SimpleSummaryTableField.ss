<h2 style="color: #4a5067;font-weight: bold;margin: 0px 0px 10px 0;display: block;font-size:1.125em;padding: 15px 0 15px 0;border-bottom: 1px solid #E0E0E0;">Order Summary</h2>

<table id="summary-list" cellspacing="0" cellpadding="0" style="width:100%;">
	<tbody>
		<tr>
			<th><h4></h4></th>
			<th><h4></h4></th>
		</tr>
		<% loop $Items %>
    		<tr>
    			<td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Product Price</p></td>
    			<td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$$ProductUnitPrice (inc GST)</p></td>
    		</tr>
    		
            <tr>
                <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Product Amount</p></td>
                <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$ProductAmount</p></td>
            </tr>
            
            <tr>
                <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Total Product Price</p></td>
                <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$$ProductPrice (inc GST)</p></td>
            </tr>
    		
    		<% if $Delivery %>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Delivery</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$$Delivery (inc GST)</p></td>
                </tr>
            <% end_if %>    
                
            <tr>
                <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Total</p></td>
                <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="color:#4a5067;padding:0;margin:0;font-weight:bold;">$$Total (inc GST)</p></td>
            </tr>
        <% end_loop %>      
        
        <% if $PaymentInfo %>
            <% loop $PaymentInfo %>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Transaction</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$TransactionID</p></td>
                </tr>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Invoice Number</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$InvoiceNumber</p></td>
                </tr>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Card Holder Name</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$CardName</p></td>
                </tr>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Card Number</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$CardNumber</p></td>
                </tr>
            <% end_loop %>
        <% end_if %>
        
        <% if $OrderDO %>
            <% loop $OrderDO %>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" colspan="2" width="100%"><h2 style="color: #4a5067;font-weight: bold;margin: 0px 0px 10px 0;display: block;font-size: 1.125em;padding: 15px 0 15px 0;border-bottom: 1px solid #E0E0E0;">Contact Details</h2></td>
                </tr>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Name</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$FirstName $LastName</p></td>
                </tr>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Email</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$Email</p></td>
                </tr>
                <tr>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Phone</p></td>
                    <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$Phone</p></td>
                </tr>
                
                <% if $Up.IsDelivery %>
                    <tr>
                        <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" colspan="2" width="100%"><h2 style="color: #4a5067;font-weight: bold;margin: 0px 0px 10px 0;display: block;font-size: 1.125em;padding: 15px 0 15px 0;border-bottom: 1px solid #E0E0E0;">Delivery</h2></td>
                    </tr>
                    <tr>
                        <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Your Address</p></td>
                        <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$Street $City $State $PostalCode</p></td>
                    </tr>
                    
                    <% if $AdditionalInfo %>
                        <tr>
                            <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Additional delivery instructions</p></td>
                            <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$AdditionalInfo</p></td>
                        </tr>
                    <% end_if %>      
                <% else %>    
                    <tr>
                        <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" colspan="2" width="100%"><h2 style="color: #4a5067;font-weight: bold;margin: 0px 0px 10px 0;display: block;font-size: 1.125em;padding: 15px 0 15px 0;border-bottom: 1px solid #E0E0E0;">Pick up</h2></td>
                    </tr>
                    <tr>
                        <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;" width="50%"><p style="color:#4a5067;font-weight:bold;padding:0;margin:0;">Pickup Address</p></td>
                        <td style="padding-top:5px;padding-right:0px;padding-bottom:10px;padding-left:0px;text-align:right;" width="50%"><p style="padding:0;margin:0;">$Up.PickupAddress</p></td>
                    </tr>
                <% end_if %>  
            <% end_loop %>
        <% end_if %>  
	</tbody>
</table>