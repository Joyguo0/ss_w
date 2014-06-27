<% include BannerNews %>
<!-- Slider -->

<% if $Gallerys %>
<div class="row collapse">
    <div class="large-12 columns">
        <div class="preloader"></div>
        <div class="jag-top grey"></div>
        <ul data-orbit>
            <% loop $Gallerys %>
            <li>
                <% if $Link %>
                <a href="$Link.LinkURL" $Link.TargetAttr>
                    <% end_if %>
                    <img alt="slide image " title="slide image" src="$Image.URL()" />
                    <% if $Link %>
                </a>
                <% end_if %>
            </li>
            <% end_loop %>
        </ul>
        <div class="jag-bottom grey"></div>
    </div>
</div>
<% end_if %>

<div class="row collapse">

    <% include IndexTab %>


    <% include IndexNews %>

</div>

<div class="row">
    <!-- LINK AND IMAGE BANNER -->

    <% if LoadPageBanners %>
    <% loop $LoadPageBanners.limit(2) %>
    <% if $Image.exists() %>
    <div class="large-4 small-12 column no-pad-left">
        <div class="sub-banner column collapse">
            <div class="large-6 small-6 column banner-content">
                <h4 class="red bebas-mid"><a href="<% if $Link %>$Link.getLinkURL<% end_if %>">$Title</a>
                </h4>
                <a href="<% if $Link %>$Link.getLinkURL<% end_if %>" class="button mid-button white-button">VIEW MORE &raquo;</a>
            </div>
            <div class="large-6 small-6 column">
                <div class="banner-image">
                    <img class="relative" src="$Image.URL()">
                    <img class="banner-image-border small-hide" src="$ThemeDir/images/banner-jag-frame.png">
                </div>
            </div>
        </div>
    </div>
    <% else %>
    <!-- centered text and link BANNER -->

    <div class="large-4 small-12 column no-pad">
        <div class="sub-banner column">
            <div class="inner-border">
                <div class="large-12 column">
                    <h4 class="bebas-mid center"><a href="<% if $Link %>$Link.getLinkURL<% end_if %>" class="white">$Title</a>
                    </h4>
                </div>
                <div class="clear"></div>
                <a href="<% if $Link %>$Link.getLinkURL<% end_if %>" class="button mid-button white-button center">VIEW MORE &raquo;</a>
            </div>
        </div>
    </div>
    <% end_if %>
    <% end_loop %>
    <% end_if %>
    <!-- centered text and link BANNER -->

    <div class="large-4 small-12 column no-pad-right">
        <div class="sub-banner column" id="find-store-banner">
            <div class="inner-border">
                <div class="large-12 column">
                    <h4 class="bebas-mid center"><a href="/" class="white">FIND A STORE</a>
                    </h4>
                    <p class="small light text-center">Search for your state, suburb, postcode or enter keywords to find your nearest store.</p>
                </div>
                <div class="large-12 column">
                    <form id="search-suburb-form" action="find-a-store" method='GET'>
                        <div class="search">

                            <input name="title" class="search-box" type="text" />

                            <a class="go" href="#" title="Click to search for this phrase">
                                <img src="$ThemeDir/images/search-icon.png">
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
