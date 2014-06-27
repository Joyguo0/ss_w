<% include BreadCrumbs %>



<div class="basic-content">
	<div class="onepcssgrid-1140">
	
		<div class="col3">
        	
            <% include SlideBarshow %>
            <div class="clear"></div>
            
        </div>
        
        <!-- Content Bit -->
        <div class="col9 last">
			<% loop $ShowShingles %>
            	<% include ShingleList %>
			<% end_loop%>
            
            <% if $getFirstPageSum %>
	            <span class="ajaxcallback"></span>
	            <div class="clear"></div>
	            <a href="javascript:void(0)" class="showmore" title="#" data-start="$ShowShingles.Count" data-link="{$Link}AjaxGetMore">Show More</a> 
            <% else %>
                <% if not $ShowShingles %>
                    <p>There is no product.</p>
                <% end_if %>    
            <% end_if %>
        </div>
        
        <div class="clear"></div>
        
  </div>
</div>

