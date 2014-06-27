<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">

    <!-- Content -->
    <div class="large-6 small-12 columns no-pad-left product-view">
        <div id="slider" class="flexslider">

            <ul class="slides">
                <% loop $ProductImages %>
                <li>
                    <img src="$Image.URL" data-zoom-image="$Image.URL" class="product-image">
                </li>
                <% end_loop %>
            </ul>

        </div>
        <div id="carousel" class="flexslider">


            <ul class="slides">
                <% loop $ProductImages %>
                <li>
                    <img src="$Image.URL" data-zoom-image="$Image.URL" class="product-image">
                </li>
                <% end_loop %>

            </ul>

        </div>

    </div>
    <div class="large-6 small-12 columns no-pad">
        <div class="columns no-pad" id="product-tabs">
            <ul class='etabs'>
                <li class='tab center'>
                    <a href="#tab-description" class="white shrink-font">DESCRIPTION</a>
                </li>
                <li class='tab center'>
                    <a href="#tab-packaging " class="white shrink-font">PACKAGING</a>
                </li>
                <li class='tab center'>
                    <a href="#tab-delivery" class="white shrink-font">DELIVERY & RETURNS</a>
                </li>
                <li class='tab center'>
                    <a href="#tab-warranty" class="white shrink-font">WARRANTY</a>
                </li>
            </ul>
            <div id="tab-description" class="small-12">
                <div class="large-4 small-12 column">
                    <h2>$Product.Title</h2>
                    <h3 class="price product-price-js">$product.getUglyPrice</h3>

                    <% if $IsFreeShipping %>
                    <div class="button red-button" id="free-shipping">FREE SHIPPING</div>
                    <% end_if %>

                    <h4>LIFESTYLE</h4>

                    <div id="icons-box" class="column">
                        <% loop getOptionsForAttribute(1) %>
                        <span data-tooltip class="tip-top driving-icon" title="$Title">
                            <img src="$ThemeDir/images/icon-driving-small-black.png">
                        </span>
                        <% end_loop %>

                    </div>

                </div>

                <div class="large-8 small-12 column no-pad-left">
                    $Product.Content
                </div>

                <div class="clear"></div>

                <div class="large-12 column sws">
                    <h4>TECH SPECS</h4>
                    <div id="icons-box" class="column tech-specs">
                        <ul class="sf-menu tool-tip">
                            <% loop $TechSpecsOptions %>
                            <li class="column">
                                $Image
                                <ul>
                                    <li>
                                        <h4>$Title</h4>
                                        <p>$Description</p>
                                    </li>
                                </ul>
                            </li>
                            <% end_loop %>
                        </ul>
                    </div>


                    <% include AddtoCart %>
                </div>
                <div class="share large-12 small-12 columns">
                    <span class='st_facebook_hcount' displayText='Facebook'></span>
                    <span class='st_twitter_hcount' displayText='Tweet'></span>
                    <span class='st_googleplus_hcount' displayText='Google +'></span>
                    <span class='st_sharethis_hcount' displayText='ShareThis'></span>
                </div>

            </div>
            <div id="tab-packaging" class="small-12">
                $PackingContent
            </div>
            <div id="tab-delivery" class="small-12">
                $SiteConfig.Delivery
            </div>
            <div id="tab-warranty" class="small-12">
                $SiteConfig.Warranty
            </div>

        </div>
        <!-- end tabs -->

    </div>
    <!-- large stockists carousel -->

    <div class="clear"></div>

    <h5 class="red">You might also be interested in</h5>
    <input type='hidden' id='linkproduct' value="$Link/linkProductInfo/" />
    <div class="large-12 column carousel relative" id="products-carousel">
        <img id="product-carou-top" src="$ThemeDir/images/product-carou-bg-top.png">
        <ul class="bxslider">
            <% loop RelatedProducts() %>
            <li>
                <div class="product-list large-3columns">
                    <a class="product-image" href="$Link">
                        <% if getProductThumbnail.exists() %>$getProductThumbnail.ResizedImage(221,147)
                        <% end_if %>
                    </a>
                    <a href="$Link">$Title</a>
                    <span class="price">$Product.getUglyPrice</span>
                </div>
            </li>
            <% end_loop %>

        </ul>
        <img id="product-carou-bottom" src="$ThemeDir/images/product-carou-bg-bottom.png">
    </div>
</div>

</div>

<!-- share this -->
<script type="text/javascript">
var switchTo5x = true;
</script>

<!-- bxSlider CSS file -->
<link href="$ThemeDir/css/jquery.bxslider.css" rel="stylesheet" />
<!-- flexslider CSS file -->
<link href="$ThemeDir/css/flexslider.css" rel="stylesheet" />
<script src="$ThemeDir/javascript/vendor/jquery.fancybox.js"></script>
<script src="$ThemeDir/javascript/vendor/jquery.bxslider.min.js"></script>
<script src="$ThemeDir/javascript/vendor/jquery.flexslider-min.js"></script>
<script src="$ThemeDir/javascript/vendor/jquery.elevatezoom.js" type="text/javascript"></script>
<script src="$ThemeDir/javascript/Attribute_OptionField.js"></script>
<script src="$ThemeDir/javascript/ProductForm.js"></script>
<script type="text/javascript">
</script>
