<% include BannerNews %>

<% include Breadcrumbs %>

<div class="row">

    <!-- top of find a store -->
    <h1>find a store</h1>
    <div class="large-8 small-12 columns no-pad-left">
        <form id="search-suburb-form" action="$Link(suburb)">
            <input name="current_link" type="hidden" id='current_link' value='$Link(getStoreDetail)' />
            <h4 class="red">13 SEARCH RESULT(S) FOR WOLLONGONG, 2500</h4>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="safety" id="safety" checked="checked"/>
                <label for="safety">SAFETY</label>
            </div>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="motorcycle" id="motorcycle" checked="checked"/>
                <label for="motorcycle">MOTORCYCLE</label>
            </div>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="polarised" id="polarised" checked="checked"/>
                <label for="polarised">POLARISED</label>
            </div>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="prescription" id="prescription" checked="checked"/>
                <label for="prescription">PRESCRIPTION</label>
            </div>




            <div class="large-12 small-12 column">
                <div class="large-5 small-12 column">
                    <div class="search full">
                        <input id="suburb-val" name="suburb" type="hidden" />
                        <input id="suburb" name="suburbLabel" class="search-box" type="text" data-source="$Link(suggestsuburb)" />
    
                        <a class="go" href="#" title="Click to search for this phrase">
                            <img src="$ThemeDir/images/search-icon.png">
                        </a>
                    </div>
                </div>
                <div class="large-6 small-12 column left">
                    <h6>Search for your state, suburb, postcode or enter a keyword to find yoru nearest store.</h6>
                </div>
            </div>
            
            
            <div class="large-12 small-12 column">
                <div class="large-5 small-12 column">
                    <div class="search full">
                        <select name="search_state" id="select-state">
                            <option value="">Search by state...</option>
                            <option value="ACT">Australian Capital Territory</option>
                            <option value="NSW">New South Wales</option>
                            <option value="NT">Northern Territory</option>
                            <option value="QLD">Queensland</option>
                            <option value="SA">South Australia</option>
                            <option value="VIC">Victoria</option>
                            <option value="WA">Western Australia</option>
                            <option value="TAS">Tasmania</option>
                        </select>
                    </div>
                </div>
                
                <div class="large-6 small-12 column left">
                </div>
            </div>
        </form>
    </div>

    <div class="large-4 small-12 columns no-pad-right">
        <!-- centered text and link BANNER -->
        <div class="sub-banner column">
            <div class="inner-border">
                <div class="large-12 column">
                    <h4 class="bebas-mid center"><a href="/" class="white">WHY NOT SHOP AT OUR ONLINE STORE?</a>
                    </h4>
                </div>
                <div class="clear"></div>
                <a href="/" class="button mid-button white-button center">SHOP NOW &raquo;</a>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    <!-- find a store map -->

    <div class="large-12 small-12 columns find-store-results" id="find-store">
        <div class="large-3 small-12 columns no-pad">
            <div class="search-results-container column" id='search-results'>
                <% if $Stores %>
                    <% loop $Stores %>
                        <a class="store search-result  $IconClass" data-id="$ID" data-lat="$Lat" data-lng="$Lng">
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

            </div>

        </div>
        
        <div class="large-9 small-12 columns no-pad-right">
            <div id="store-locator-map"></div>
        </div>

        <div class="clear"></div>

        <div class="large-9 small-12 column push-3 store-details">
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

    <!-- online stockists toggle -->
    <div class="large-12 toggle">
        <div class="toggle-trigger">
            <h4 class="light">our products are available from these online retailers</h4>
        </div>
        <div class="toggle-content column">
            <ul class="sf-menu tool-tip">
                <% loop $OnlineStores.limit(8) %>
                <li class="large-3 small-6 column">
                    <img src="$Image.URL" />
                    <ul>
                        <li>
                            <div>
                                <p>$Title</p>
                                <a href="$Link" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="$Link">$Email</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <% end_loop %>

            </ul>
        </div>
    </div>

    <div class="large-12 toggle">
        <div class="toggle-trigger">
            <h4 class="light">UGLY FISH SAFETY WHOLESALE DISTRIBUTORS</h4>
        </div>
        <div class="toggle-content column">
            <ul class="sf-menu tool-tip">
                <% loop $Distributors.limit(8) %>
                <li class="large-3 small-6 column">
                    $Image
                    <ul>
                        <li>
                            <div>
                                <p>$Title</p>
                                <a href="$Link" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="$Link">$Email</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <% end_loop %>
            </ul>
        </div>
    </div>
</div>
