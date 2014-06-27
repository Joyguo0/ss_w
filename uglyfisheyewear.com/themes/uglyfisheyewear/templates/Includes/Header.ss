<header>
    <div class="column" id="top-links">
        <div class="row collapse">
            <div class="large-4 columns small-12 push-8">
                <a href="$LoadCartPage.Link" id="view-cart">View Cart</a>

                <% if Member.CurrentUser %>
                <%-- <a href="account" id="account">My Account</a>--%>
                    <a href="Security/logout" id="login-link">Log Out</a>
                    <% else %>
                    <a href="Security/login" id="login-link">login/ Register</a>
                    <% end_if %>

                    <a href="$LoadStoreLocatorPage.Link" id="find-store-link">Find a Store</a>
            </div>

            <div class="large-8 columns small-12 pull-4">
                <% include Navigation %>
            </div>
        </div>
    </div>
    <!-- Header and Nav -->
    <div class="column" id="middle-head">
        <div class="row collapse">
            <div class="large-3 small-12 columns" id="logo">
                <img class="small-hide" alt="logo" title="logo" src='$SiteConfig.Toplogo.url()' />
                <img class="hide mobile-logo center" alt="logo" title="logo" src="$SiteConfig.Toplogo.url()">
            </div>
            <div class="large-6 small-12 columns">
                <div class="search">
                    <% loop $ProdcutSearchForm %>
                    <form $FormAttributes>
                        <input type="text" maxlength="250" id="txtSearch" name="Search" class="search-box" placeholder="SEARCH UGLY FISH PRODUCTS">
                        <a class="go" href="#" title="Click to search for this phrase">
                            <img src="$ThemeDir/images/search-icon.png">
                        </a>
                    </form>
                    <% end_loop %>


                </div>
            </div>
            <div class="large-3 small-12 columns">
                <% include Country %>
            </div>
            <ul class="social right small-hide">
                <% loop $SiteConfig.Follows %>
                <li class="$IconClass">
                    <a href="<% if $Blink %>$Blink.getLinkURL<% end_if %>" alt="Follow Ugly Fish on Facebook" title="$Title"></a>
                </li>
                <% end_loop %>
            </ul>
        </div>
    </div>


    <% include ProductNav %>


</header>
<!-- End Header and Nav -->
