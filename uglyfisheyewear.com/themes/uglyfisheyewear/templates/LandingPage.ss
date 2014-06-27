<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <% base_tag %>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Ugly Fish Eyewear</title>


        <!--[if IE 8]><link rel="stylesheet" href="$ThemeDir/css/ie8.css">
        <![endif]-->

        <!-- web fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>


</head>

<body id="landing-page">
    <header>
        <div class="column" id="middle-head">
            <div class="row collapse">
                <div class="large-3 small-12 columns" id="logo">
                    <img class="small-hide" alt="logo" title="logo" src='$SiteConfig.Toplogo.url()' />
                    <img class="hide mobile-logo center" alt="logo" title="logo" src="$SiteConfig.Toplogo.url()" />
                </div>
                <div class="large-6 small-12 columns">
                    <div class="search float-right">
                        <% loop $SearchForm %>
                            <form $FormAttributes>
                                <input type="text" maxlength="250" id="txtSearch" name="Search" class="search-box" placeholder="SEARCH UGLY FISH PRODUCTS">
                                <a class="go" href="#" title="Click to search for this phrase">
                                    <img src="$ThemeDir/images/search-icon.png">
                                </a>
                            </form>
                            <% end_loop %>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- End Header and Nav -->
    <div class="clear"></div>
    <div class="row">
        <div class="jag-top grey"></div>

        <div id="landing-banner" style='background: url($ThemeDir/images/landing-gradient.png) 0 0 repeat-y, url($RightImage.URL()) 0 0 no-repeat;'>
            <div id="landing-banner-content" class="large-5 column">
                <h1 class="red">$SubTitle</h1>
                <p>$TopContent</p>
                <a href="<% if $Link %>$Link.getLinkURL<% end_if %>" class="button white-button">SHOP NOW &raquo;</a>
            </div>
        </div>


        <div class="jag-bottom grey"></div>
    </div>

    <div class="clear"></div>

    <!-- BANNERS -->
    <div class="row">
        <% loop $LandingBanner %>
            <!-- LINK AND IMAGE BANNER -->
            <div class="large-4 small-12 column no-pad-left">
                <div class="sub-banner column collapse">
                    <div class="large-6 small-6 column banner-content">
                        <h4 class="red bebas-mid"><a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>">$Title</a>
                        </h4>
                        <a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>" class="button mid-button white-button">SHOP NOW &raquo;</a>
                    </div>
                    <div class="large-6 small-6 column">
                        <div class="banner-image">
                            <img class="relative" src="$Oimage.URL()">
                            <img class="banner-image-border small-hide" src="$ThemeDir/images/banner-jag-frame.png">
                        </div>
                    </div>
                </div>
            </div>
            <% end_loop %>
    </div>
    <div class="row" id="landing-content">
        <div class="large-12 column white-content-area jagged">
        
        
            <div class="<% if $Form %>large-8<% else %>large-12<% end_if %> column">
                $Content
            </div>
            
            <% if $Form %>
                <div class="large-4 column">
                    <div id="landing-form">
                        <div class="large-12 column">
                            $Form
                        </div>
                    </div>
                </div>
            <% end_if %>
            
        </div>
    </div>
    </div>

    <!-- Footer 4 - 4col -->
    <footer>
    
    </footer>
</body>

</html>
