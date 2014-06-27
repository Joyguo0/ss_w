<% with Cart %>
<table id="checkout-order-table" class="table table-bordered">
	<tbody>	

        <tr>
            <td class="sub-left">SUBTOTAL</td>
            <td class="sub-right">$SubTotalPrice.Nice</td>
        </tr>
        
        $Top.SubTotalModificationsFields
                        
        $Top.TotalModificationsFields
        
        <tr class="grand-total">
            <td class="sub-left">GRAND TOTAL</td>
            <td class="sub-right">$TotalPrice.Nice</td>
        </tr>

	</tbody>
</table>
<% end_with %>