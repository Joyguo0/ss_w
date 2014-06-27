<tr>
    <td class="cart-image">
        <a href="$Item.Product.Link" target="_blank">$Item.Product.ProductThumbnail.SetSize(143,97)</a>
    </td>
    
    <td>
        <p>
            <strong>
                <% if Item.Product.isPublished %>
                    <a href="$Item.Product.Link" target="_blank">$Item.Product.Title</a>
                <% else %>
                    $Item.Product.Title
                <% end_if %>
            </strong>
            
            <br>
            
            <strong>$Item.SummaryOfOptions</strong>
            
            <% if Message %>
                <div class="message $MessageType">
                    $Message
                </div>
            <% end_if %>
        </p>
    </td>

	<td class="quantity">
		<div id="$Name" class="field $Type $extraClass">
			$titleBlock
			<div class="middleColumn">$Field</div>
			$rightTitleBlock
		</div>
	</td>
	
	<td class="remove">
	
	   <a name="remove_a" href="javascript:void(0)" data-id="$Item.ID" class="button small-button remove" data-link="{$Form.Controller.LoadCartPage.Link('CartForm/remove')}">REMOVE</a>
	  
	</td>
	
	<td class="edit">
	   <a name="edit_a" href="javascript:void(0)" data-id="$Item.ID" class="button small-button edit" data-link="{$Form.Controller.LoadCartPage.Link('CartForm/edit')}">EDIT</a>
	</td>
	
    <td class="price">
        $Item.UnitPrice.Nice
    </td>
	
	<td class="price">
		$Item.TotalPrice.Nice
	</td>
</tr>
