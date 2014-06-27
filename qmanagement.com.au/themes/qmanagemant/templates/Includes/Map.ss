<div class="search-results-container column" id='search-results'>
    <% if $BuildingAddresses %>
    <% loop $BuildingAddresses %>
    <div class="store" data-id="$ID" data-lat="$Lat" data-lng="$Lng">
        <a class="search-result <% if $First %>active <%end_if%> $IconClass">
            <h5>$Title</h5>
            <p>$Address</p>
            <p>
                <% if $Distance %>({$Distance.Nice}km)
                <% end_if %>
            </p>
        </a>
    </div>
    <% end_loop %>

    <% else %>

    <p>No Search Results! Please search again or reset map</p>

    <% end_if %>

</div>


<div id="store-locator-map"></div>
<div style='clear: both;'></div>
