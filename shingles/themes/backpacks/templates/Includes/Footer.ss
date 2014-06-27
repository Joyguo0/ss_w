
<!-- Footer -->
<footer>
    <div class="onepcssgrid-1140">
    
		
        
        <div class="col3">
	        $SiteConfig.Photo
        </div>
        <div class="col6">
        	<h6>Also See:</h6>
            <div class="swap">
                <% loop $SubSiteList %>
                	<% if $Current %>
                		
                	<% else %>
                		<a href="http://{$Domain}" title="$Title">$Title</a>
                	<% end_if %>
				<% end_loop %>
				
                <div class="line"></div>
                <div class="or">or</div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="col3 last">
        	$SiteConfig.FooterLogoText
        </div>
        
        <div class="clear"></div>

	</div>
</footer>

<!-- Footer Bottom Bit -->
<div class="footer-bottom">
    <div class="onepcssgrid-1140">
    
        <div class="col8">
            <p>
                &copy; Copyright 2014 <a href="#" title="American Shingles" style="margin-right: 10px;">American Shingles</a>
                
                <% loop $SiteConfig %>
                    <% if $PrivacyLink %>
                        <a class="plink" href="$PrivacyLink.getLinkURL" $PrivacyLink.getTargetAttr title="$PrivacyLink.Title">$PrivacyLink.Title</a>
                    <% end_if %>
                    
                    <% if $ECommerceLink %>
                        <a class="plink" href="$ECommerceLink.getLinkURL" $ECommerceLink.getTargetAttr title="$ECommerceLink.Title">$ECommerceLink.Title</a>
                    <% end_if %>
                    
                    <% if $TermsLink %>
                        <a class="plink" href="$TermsLink.getLinkURL" $TermsLink.getTargetAttr title="$TermsLink.Title">$TermsLink.Title</a>
                    <% end_if %>
                <% end_loop %>        
            </p>
        </div>
        <div class="col4 last">
            <p>Site by <a href="http://www.internetrix.com.au" title="Internetrix">Internetrix</a></p>
        </div>
        <div class="clear"></div>
        
    </div>
</div>