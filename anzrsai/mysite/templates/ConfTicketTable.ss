<table class="event">
    <tbody>
        <tr>
            <td></td>
            <td></td>
            <th></th>
            <th>Fees (Australian Dollars)</th>
            <th>Quantity</th>
        </tr>
            
        <% loop $Records %>    
            <tr>
                <td><input class="qtycheck" type="radio" name="$ClassName" value="$ID" <% if $Up.SelectedTicketID = $ID %>checked="checked"<% end_if %> required="required" aria-required="true"></td>
                <td class="ticket-details"><strong>$Name</strong><br>$Description</td>
                <td class="prices"></td>
                <td class="prices">$$MemberPrice AUD</td>
                <td><input type="number" class="ticket-quantity" value="<% if $Up.SelectedTicketID = $ID %>$Up.TicketQty<% else %><% end_if %>" name="$ClassName-$ID-QTY" <% if $Up.SelectedTicketID = $ID %>required="required" aria-required="true"<% end_if %>></td>
           </tr>
        <% end_loop %>        
   </tbody>
</table>