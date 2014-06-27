<!-- Footer 4 - 4col -->
<footer>
    <img id="footer-jag" src="$ThemeDir/images/footer-bg.gif" alt="footer background texture">
    <div class="column footer-1">
        <div class="row">
            <div class="large-12 columns no-pad">
                <div class="footer-col small-12 column">
                    $SiteConfig.FootContent1

                </div>
                <div class="footer-col small-12 column">
                    $SiteConfig.FootContent2

                </div>
                <div class="footer-col small-12 column">
                    $SiteConfig.FootContent3
                </div>
                <div class="footer-col small-12 column ugly-since">
                    $SiteConfig.FootContent4
                </div>
                <div class="footer-col small-12 column no-pad">
                    <h5>NEWSLETTER SIGN UP</h5>
                    <div id="newsletter-signup">
                        $NewsletterRegisterForm
                    </div>
                    <h5>STAY CONNECTED</h5>
                    <ul class="social">
                        <% loop $SiteConfig.Follows %>
                        <li class="$IconClass">
                            <a href="<% if $Blink %>$Blink.getLinkURL<% end_if %>" alt="Follow Ugly Fish on Facebook" title="$Title"></a>
                        </li>
                        <% end_loop %>

                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="column footer-2">
        <div class="row">
            <div class="large-12 columns">
                <div class="large-4 small-12 column">
                    <p>
                        We Accecpt -
                        <img src="$ThemeDir/images/icon-visa.jpg">
                        <img src="$ThemeDir/images/icon-mastercard.jpg">
                        <img src="$ThemeDir/images/icon-paypal.jpg">
                    </p>
                </div>
                <div class="large-4 small-12 column">
                    <p class="text-center cond">
                        $SiteConfig.Tel
                    </p>
                </div>
                <div class="large-4 small-12 column">
                    <% include Country %>
                </div>
            </div>
        </div>
    </div>
    <div class="column footer-3">
        <div class="row">
            <div class="large-12 columns">
                <div class="large-2 small-12 column">
                    <p>
                        Site by <a href="http://www.internetrix.com.au">Internetrix</a>
                    </p>
                </div>
                <div class="large-8 small-12 column text-center">
                    $SiteConfig.FootLink
                </div>
                <div class="large-2 small-12 column">
                    <p class="right">
                        $SiteConfig.Copyright
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>
