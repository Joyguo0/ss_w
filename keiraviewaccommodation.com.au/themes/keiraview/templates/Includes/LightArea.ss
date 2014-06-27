<div class="light-area">
	<% loop $Detailtabs %>
			<div class="col3">
                <h5>$Title</h5>
                <p>$Content</p>
                <a class="button" href="$Link.LinkURL"  $Link.TargetAttr>$Link.Title</a>
            </div>
	<% end_loop %>
    <div class="col3 last">
        <a class="yha" href="<% if $SiteConfig.FootRightLink %>$SiteConfig.FootRightLink.getLinkURL<% end_if %>">$SiteConfig.FootRight</a>
    </div>
    
    <div class="rightdash"></div>
    
    <div class="clear"></div>
</div>