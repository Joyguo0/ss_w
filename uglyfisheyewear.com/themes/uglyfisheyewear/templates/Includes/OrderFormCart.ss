<% with Cart %>
<table id="checkout-order-table" class="cart">
	<thead>
		<tr>
			<th class="text-left">ITEM DESCRIPTION</th>
	        <th>PRICE</th>
	        <th>QTY</th>
	        <th>SUBTOTAL</th>
		</tr>
	</thead>
	<tbody>
	
		<% if Items %>
		
			<% loop Top.ItemsFields %>
				$FieldHolder
			<% end_loop %>
			
		<% else %>
			<tr>
				<td colspan="4">
					<div class="error"><% _t('CheckoutFormOrder.NO_ITEMS_IN_CART','There are no items in your cart.') %></div>
				</td>
			</tr>
		<% end_if %>

		<% loop Top.SubTotalModificationsFields %>
			$FieldHolder
		<% end_loop %>
		
		<tr class="subtotal">
			<td class="text-left">
				<p>
				<strong><% _t('CheckoutFormOrder.SUB_TOTAL','Sub Total') %></strong>
				</p>
			</td>
			<td class="no-border"></td>
			<td class="no-border"></td>
			<td class="price">$SubTotalPrice.Nice</td>
		</tr>
		
		<% loop Top.TotalModificationsFields %>
			$FieldHolder
		<% end_loop %>

		<tr class="grand-total">
			<td class="text-left">
	            <p>
	                <strong>GRAND TOTAL</strong>
	            </p>
            </td>
            <td class="no-border"></td>                                                
            <td class="no-border"></td>
            <td class="price">$TotalPrice.Nice</td>
		</tr>

	</tbody>
</table>
<% end_with %>