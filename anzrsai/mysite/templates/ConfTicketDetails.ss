<table class="event">
    <tbody>
        <tr>
            <td></td>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        
        <% loop $Record %>
            <tr>
                <td class="ticket-details"><strong>$Name</strong><br>$Description</td>
                <td class="prices">$$FinalTicketPrice AUD</td>
                <td class="prices">$TicketQTY</td>
                <td class="prices">$$TotalTicketPrice AUD</td>
           </tr>
       <% end_loop %>
</table>
