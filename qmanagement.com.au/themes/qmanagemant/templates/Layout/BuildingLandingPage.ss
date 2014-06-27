<script>
// Can also be used with $(document).ready()
$(window).load(function() {
    $('.flexslider').flexslider({
        animation: "fade",
        controlNav: false,
        start: function(slider) {
            $('.flexslider').removeClass('loading');
        }

    });
});

$(document).ready(function() {
    $('.lightbox').magnificPopup({
        delegate: 'a', // child items selector, by clicking on it popup will open
        type: 'image',
        gallery: {
            enabled: true
        }
    });
});
</script>
<div class="bp-bannertop">
    <div class="bp-over">
        <!--Gradient Background Colour -->
        <!-- <div class="bp-over" style="background: rgb(150, 85, 141);
        background: -moz-linear-gradient(top, rgba(150, 85, 141, 1)  0%, rgba(180, 128, 174, 1) 100%);
        background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(150, 85, 141, 1) ), color-stop(100%,rgba(180, 128, 174, 1)));
        background: -webkit-linear-gradient(top, rgba(150, 85, 141, 1)  0%,rgba(180, 128, 174, 1) 100%);
        background: -o-linear-gradient(top, rgba(150, 85, 141, 1)  0%,rgba(180, 128, 174, 1) 100%);
        background: -ms-linear-gradient(top, rgba(150, 85, 141, 1)  0%,rgba(180, 128, 174, 1) 100%);
        background: linear-gradient(to bottom, rgba(150, 85, 141, 1)  0%,rgba(180, 128, 174, 1) 100%);"> -->

        <div class="row">

            <div class="large-6 medium-12 columns">
                <!-- Info -->
                <div class="overlay">

                    <h1>$Title</h1>
                    <!-- style="text-shadow: 0px 1px 0px darkcolour;" -->
                    <p class="bcrumbs" style='color: #753977;'>$BreadCrumbs</p>

                    <!-- span class="next" style="background: lightcolour;" -->
                    <!-- span class="current" style="background: darkcolour;" -->

                    <div class="break"></div>
                    <!-- style="background: lightcolour;" -->

                    <p>$ShortDescription</p>

                    <h3 class="phone">
                        <a href="tel:$Call">
                            <span></span>$Call</a>
                    </h3>
                    <h3 class="email">
                        <a href="mailto:$$Email">
                            <span></span>$Email</a>
                    </h3>

                </div>
            </div>

            <div class="large-6 medium-12 columns">
                <!-- Slider -->
                <div class="slideshow">
                    <div class="flexslider loading">
                        <ul class="slides lightbox">
                            <% if $Gallerys %>
                            <% loop $Gallerys %>

                            <li>
                                <a href="$Image.URL()">
                                    <img alt="$Title" title="$Title" src="$Image.URL()" />
                                </a>
                            </li>
                            <% end_loop %>
                            <% end_if%>
                        </ul>
                    </div>
                </div>
                <!-- End Slider -->
            </div>

        </div>

    </div>
</div>


<div class="whitearea">
    <div class="row">

        <div class="sidebar large-2 medium-3 columns">
            <div class="bp-info">
                <h5>Location</h5>
                <p>$Address,$Suburb,$State,$Postcode</p>
                <h5>Estimated Completion</h5>
                <p>$dateFormatE</p>
                <h5>Information</h5>
                <p>$Information</p>
            </div>
        </div>

        <div class="content large-7 medium-6 columns">
            <div class="big">
                <h5>$ShortDescription</h5>
                $Content
            </div>
        </div>

        <div class="sidebar large-3 medium-3 columns">
            $Form
        </div>

    </div>
</div>


<!-- Building Map -->
<div class="gmap">
    <% include MapContent %>
</div>
