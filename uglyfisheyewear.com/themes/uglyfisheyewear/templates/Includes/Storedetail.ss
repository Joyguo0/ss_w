<% if Stores %>
<% loop $Stores %>
<div class="large-4 small-6 column" data-id="$ID" data-lat="$Lat" data-lng="$Lng" id='detaildata'>
    <h4 class="red">$Title</h4>
    <p class="address">$Address
        <br>$State $country $Postcode</p>
</div>
<div class="large-4 small-6 column">
    <p class="phone">$PhoneNumber</p>
    <p class="email"><a href="/">$Email</a>
    </p>
    <p class="url"><a href="/">www.eyecareplus.com.au</a>
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

<% end_if %>
<% end_loop %>
