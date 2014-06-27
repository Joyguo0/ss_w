<% include Banner %>

<!-- White Area -->
<div class="white-area">
	<div class="onepcssgrid-1140">
        <div class="main-area">
            <% include Loannav %>
            
		    <div class="col9 last">

                    <div class="content typography">

                        <% if $SubTitle %><h1>$SubTitle</h1><% end_if %>
                        <% if $Content %>$Content<% end_if %>                      

                    </div>
                    
                    <% if $LoadJumpToLinks %>
                         <!-- Jump To: -->
                        <div class="jumpto">
                            <h5>Jump to:</h5>
                            <ul id="box-links">
                                <% loop $LoadJumpToLinks %>
                                    <li class="$IconClass"><a href="$Blink.getLinkURL" title="$Title"></a><span>$Title</span></li>
                                <% end_loop %>
                            </ul>
                            <div class="clear"></div>
                        </div>
                    <% end_if %>

                    <div class="loans-mainlisting">
                        
                        <% loop $LoanPages %>
                             <div id="$IconClass-loan" class="loan-listed">
                                <a class="loan-icon-big" href="$Link"><span class="$IconClass"></span></a>
                                <h5><a href="$Link">$Title</a></h5>
                                <p>$Content.FirstParagraph</p>
                                <a class="small-button" href="$Link">Read More</a>
                            </div>
                        <% end_loop %>
                    </div>

			</div>
			<div class="clear"></div>
	  </div> 
		    	
	</div>
	<div class="clear"></div>
</div>
