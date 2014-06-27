<% if StoreDetail %>
	<% loop $StoreDetail %>
	
		<div class="large-4 small-6 column" data-id="$ID" data-lat="$Lat" data-lng="$Lng" id='detaildata'>
		    <h4 class="red">$Title</h4>
		    <p class="address">$Address
		        <br>$Suburb $State $Postcode</p>
		</div>
		
		<div class="large-4 small-6 column">
		    <% if $PhoneNumber %><p class="phone">$PhoneNumber</p><% end_if %>
		    <% if $Email %><p class="email"><a href="mailto:$Email">$Email</a></p><% end_if %>
		    <% if $Website %><p class="url"><a href="$WebsiteUrl" target="_blank">$Website</a><% end_if %>
		    </p>
		</div>
		
		<div class="large-4 small-12 column product-range-key">
		    <h5>PRODUCT RANGE IN STORE</h5>
		    
		    <% if $Prescription %>
		    	<div class="bebas white large-6 small-6 column">PRESCRIPTION</div>
		    <% end_if %>
		    
		    <% if $Safety %>
		    	<div class="bebas white large-6 small-6 column">SAFETY</div>
		    <% end_if %>
		    
		    <% if $Polanrised %>
		    	<div class="bebas white large-6 small-6 column">POLARISED</div>
		    <% end_if %>
		    
		    <% if $Riderz %>
		    	<div class="bebas white large-6 small-6 column float-left">MOTORCYCLE</div>
		    <% end_if %>
		</div>
	
	<% end_loop %>
<% end_if %>
