<!-- New Content Area -->
<div class="dark-area">
	<div class="onepcssgrid-1140">
        <div class="col12">
        	 $Content2
        </div>
        <div class="clear"></div>
	</div>
</div>


<!-- White Area -->
<div class="white-area">
   

    <!-- Loans Horizontal -->
    <div class="onepcssgrid-1140 loans-horiz-area">
        <% loop $LoanPages.Limit(7) %>
                <div class="col1of7<% if $Even %> second<%end_if%> $FirstLast">
                    <a class="loans-horiz" href="$Link">
                        <div class="$IconClass"></div>
                        <h6>$Title</h6>
                    </a>
                </div> 
        <% end_loop %>
        <div class="clear"></div>
     </div>

    <div class="onepcssgrid-1140">
        <div class="col4"><div class="space"></div></div>
        <div class="col4">
            <div class="middle-bit typography">
                 $Content
            </div>
        </div>
        <div class="col4 last"><div class="space"></div></div>
    </div>
     <div class="onepcssgrid-1140">
        
            <% loop $Features.Limit(4) %>
            <div class="col6 <% if $Even %>last<% end_if%>">
                <div class="feature">
                    <h5>$Title</h5>
                    <p>$Content</p>
                    <div class="feature-icon $IconClass"><span></span></div>
                </div>
             </div>
            <% end_loop %>
            
        <div class="clear"></div>
        <div class="col4"><div class="space"></div></div>
        <div class="col4"><a class="button" title="$SiteConfig.ApplyForPreapproval.Title"   href="<% if $SiteConfig.ApplyForPreapproval %>$SiteConfig.ApplyForPreapproval.getLinkURL<% end_if %>">$SiteConfig.ApplyForPreapproval.Title</a></div>
        <div class="col4 last"><div class="space"></div></div>
    </div>
    
    <div class="clear"></div>   
</div>
