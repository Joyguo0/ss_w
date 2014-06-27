<% if Stores %>
    <% loop Stores %>
        <a class="store search-result $IconClass" data-id="$ID" data-lat="$Lat" data-lng="$Lng">
            <h5>$Title</h5>
            <p>$Address</p>
            <p>$Suburb $State $Postcode</p>
            <p>
                <% if $Distance %>({$Distance.Nice}km)<% end_if %>
            </p>
        </a>
    <% end_loop %>
<% else %>

    <p>No Search Results! Please search again or reset map</p>

<% end_if %>
