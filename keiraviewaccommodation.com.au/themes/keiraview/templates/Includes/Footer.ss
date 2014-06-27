<footer>
	<div class="onepcssgrid-1140">
		<div class="col4">
        	<a href="<% if $SiteConfig.FootlogoLink %>$SiteConfig.FootlogoLink.getLinkURL<% end_if %>">$SiteConfig.Footlogo</a>
        </div>
        <div class="col8 last">
        	<p>$SiteConfig.FootContent <a href="<% if $SiteConfig.FootContentLink %>$SiteConfig.FootContentLink.getLinkURL<% end_if %>">$SiteConfig.FootContentLink</a>.</p>
        </div>
		<div class="clear"></div>
	</div>
</footer>