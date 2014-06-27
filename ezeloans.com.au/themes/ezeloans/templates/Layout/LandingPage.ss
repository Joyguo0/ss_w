<!-- White Area -->
<div class="white-area">

    <!-- Loans Horizontal -->
    <div class="onepcssgrid-1140 loans-horiz-area">
           	<div class="col2"><div class="space"></div></div>
        <div class="col8">
        	<div class="content typography">
                    <p>$Content</p>
             </div>
		</div>            
		<div class="col2 last"></div> 
        <div class="clear"></div>              
    </div>

</div>

<!-- Call to Action -->
<div class="calltoaction-area">
	<div class="onepcssgrid-1140">
        <div class="col12">
        	<h3><span>$BottomTitle</span> $BottomTitle2 
        	   <% if $BottomLink.Title %>
        	       <% loop $BottomLink %>
        	           <a $TargetAttr href="$LinkURL">$Title</a>
        	       <% end_loop %>
        	   <% end_if %>
        	</h3>
        </div>
        <div class="clear"></div>
    </div>
</div>
