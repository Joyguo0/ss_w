<% include Banner %>

<!-- White Area -->
<div class="white-area">
	<div class="onepcssgrid-1140">
        <div class="main-area">
        	<% include Loannav %>
		    <div class="col9 last">
 				<div class="loan-page-title">

                    <div class="icon-giant $IconClass"> </div>
                    <div class="content typography">
						
                        <% if $SubTitle %><h1>$SubTitle</h1><% end_if %>
                        <% if $Content %><p>$Content</p><% end_if %>
                        <a class="content-button"  href="<% if $SiteConfig.ApplyForPreapproval %>$SiteConfig.ApplyForPreapproval.getLinkURL<% end_if %>">$SiteConfig.ApplyForPreapproval.Title</a>
                        

                    </div>
                </div>
		    	
		    	<div class="clear"></div>
		    	
                <!-- Tabbed Area -->
                <div class="tabbed-area">
                    <div id="tab-container" class="tab-container">
                        <ul class='etabs'>
                            <!-- Tab Titles: These need to match some tab content below -->
                            <% loop $LoanTabs %>
								<li class='tab'><a href="#tabs$Pos">$Title</a></li>
							<% end_loop %>
                            <div class="clear"></div>
                        </ul>
                        
                        <% loop $LoanTabs %>
							<div class="tab-content" id="tabs$Pos">
	                            <div class="content typography">
	                                <% if $Content %><p>$Content</p><% end_if %>
	                            </div>
	                        </div>
						<% end_loop %>
                       
                    </div>  
                </div>  

			</div>
	  </div> 
		    	
	</div>
	<div class="clear"></div>
</div>
