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
                <td>
                    <input class="qtycheck reste-$ClassName-$ID" type="checkbox" name="HFTickets[{$ID}]" value="$ID" class="hidden-field" <% if $ThisIsChecked %>checked="checked"<% end_if %>>
                    <span class="custom checkbox"></span>
                </td>
                <td class="ticket-details"><strong>$Name</strong><br>$Description</td>
                <td class="prices"></td>
                <td class="prices">$$MemberPrice AUD</td>
                <td>
                    <input type="number" for="reste-$ClassName-$ID" class="ticket-quantity HFTickets-QTY-$ID" value="<% if $ThisQTY %>$ThisQTY<% else %><% end_if %>" name="HFTicketsQTY[{$ID}][QTY]" <% if $ThisIsChecked %>required="required" aria-required="true"<% end_if %>>
                </td>
           </tr>
        <% end_loop %>      
    </tbody>
</table>