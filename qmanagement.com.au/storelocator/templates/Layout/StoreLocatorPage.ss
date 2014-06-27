<div class="row">



    <div class="large-12 small-12 columns find-store-results" id="find-store">
        <div class="large-3 small-12 columns no-pad">
            <div class="search-results-container column" id='search-results'>
                <% if $Stores %>
                <% loop $Stores %>
                <div class="store" data-id="$ID" data-lat="$Lat" data-lng="$Lng">
                    <a class="search-result <% if $First %>active <%end_if%> $IconClass">
                        <h5>$Title</h5>
                        <p>2/32 Crown Street</p>
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

        </div>
        <div class="large-9 small-12 columns no-pad-right">
            <div id="store-locator-map"></div>
        </div>

        <div class="clear"></div>

        <div class="large-9 small-12 column push-3 store-details">
            <div class="large-4 small-6 column">
                <h4 class="red">EYECARE PLUS WOLLONGONG</h4>
                <p class="address">2/232 Crown Street
                    <br>Wollongong NSW 2500</p>
            </div>
            <div class="large-4 small-6 column">
                <p class="phone">02 4228 4588</p>
                <p class="email"><a href="/">info@email.com.au</a>
                </p>
                <p class="url"><a href="/">www.eyecareplus.com.au</a>
                </p>
            </div>
            <div class="large-4 small-12 column product-range-key">
                <h5>PRODUCT RANGE IN STORE</h5>
                <div class="bebas white large-6 small-6 column">PRESCRIPTION</div>
                <div class="bebas white large-6 small-6 column">SAFETY</div>
                <div class="bebas white large-6 small-6 column">POLARISED</div>
                <div class="bebas white large-6 small-6 column float-left">MOTORCYCLE</div>
            </div>
        </div>

        <div class="large-3 small-12 column pull-9 store-key">
            <div class="large-12 small-4 column">
                <img src="$ThemeDir/images/icon-gold.png" alt="Gold">
                <p class="small">Gold Providers stock a large range of Ugly Fish Eyewear</p>
            </div>
            <div class="large-12 small-4 column">
                <img src="$ThemeDir/images/icon-silver.png" alt="silver">
                <p class="small">Silver Providers stock a range of Ugly Fish Eyewear</p>
            </div>
            <div class="large-12 small-4 column">
                <img src="$ThemeDir/images/icon-bronze.png" alt="bronze">
                <p class="small">Gold Providers stock a smaller range of Ugly Fish Eyewear</p>
            </div>
        </div>



    </div>
</div>
