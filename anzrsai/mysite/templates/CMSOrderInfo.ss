<table cellspacing="0" cellpadding="0" style="border-spacing: 1px; width: 680px; border-collapse:collapse;">
    <tbody>
        <tr style="background-color: #46acd9;">
            <td></td>
            <th style="color: #ffffff; font-weight: normal; font-size: 14px; border-1px solid #ffffff; border-collapse: collapse;">Price</th>
            <th style="color: #ffffff; font-weight: normal; font-size: 14px; border-1px solid #ffffff; border-collapse: collapse; width:70px;">QTY</th>
            <th style="color: #ffffff; font-size: 14px; border-1px solid #ffffff; border-collapse: collapse;">Total</th>
        </tr>

        <% loop $Tickets %>
            <tr style="background-color: #f0f0f0;">
                <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; padding-left: 5px;" ><strong>$Name</strong>
                <br>
                $Description</td>
                <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; padding-left: 5px;">$$FinalTicketPrice AUD</td>
                <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; text-align:center;">$TicketQTY</td>
                <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; font-weight: bold; text-align: center;">$$TotalTicketPrice AUD</td>
            </tr>
        <% end_loop %>
    </tbody>
</table>