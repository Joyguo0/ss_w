<% include BannerNews %>

<% include Breadcrumbs %>

<div class="row">

    <!-- top of find a store -->
    <h1>find a store</h1>
    <div class="large-8 small-12 columns no-pad-left">
        <form id="search-suburb-form" action="$Link(suburb)">
            <input name="store_id" type="hidden" id='store_id' />
            <h4 class="red">13 SEARCH RESULT(S) FOR WOLLONGONG, 2500</h4>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="safety" id="safety" />
                <label for="safety">SAFETY</label>
            </div>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="motorcycle" id="motorcycle" />
                <label for="motorcycle">MOTORCYCLE</label>
            </div>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="polarised" id="polarised" />
                <label for="polarised">POLARISED</label>
            </div>
            <div class="large-3 small-6 column no-pad inline">
                <input type="checkbox" name="prescription" id="prescription" />
                <label for="prescription">PRESCRIPTION</label>
            </div>
            <div class="large-3 small-6 column no-pad inline">
                <H4 class=" column no-pad">search by state</H4>
                <select name="search_state" id="select-state">
                    <option value="">Please select...</option>
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

    <!-- online stockists toggle -->
    <div class="large-12 toggle">
        <div class="toggle-trigger">
            <h4 class="light">our products are available from these online retailers</h4>
        </div>
        <div class="toggle-content column">
            <ul class="sf-menu tool-tip">
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-2.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-1.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-4.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-3.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-4.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-3.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-2.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-1.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>

    <div class="large-12 toggle">
        <div class="toggle-trigger">
            <h4 class="light">UGLY FISH SAFETY WHOLESALE DISTRIBUTORS</h4>
        </div>
        <div class="toggle-content column">
            <ul class="sf-menu tool-tip">
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-2.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-1.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-4.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-3.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-4.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-3.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-2.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>

                <li class="large-3 small-6 column">
                    <img src="$ThemeDir/images/logo-1.jpg" />
                    <ul>
                        <li>
                            <div>
                                <p>LOREM IPSUM DOLOR</p>
                                <a href="/" class="button white-button mid-button">VISIT ONLINE STORE</a>
                                <a href="/">email@theinternet.com.au</a>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
