<% include BreadCrumbs %>


<div class="basic-content">
	<div class="onepcssgrid-1140">
        
        
        <div class="col3">
        	
            <!-- Sidebar Navigation -->
            
            <% include SlideBarshow %>
            <div class="clear"></div>
            
            <!-- Showcase Sidebar -->
            
            
        </div>
        
        
        <!-- Content Bit -->
        <div class="col9 last">
            
           	<% loop $ShowCases %>
            	<% include CaseList %>
			<% end_loop%>
            
            <span class="ajaxcallback"></span>
            
            <div class="clear"></div>
            <a href="javascript:void(0)" class="showmore" title="#" data-start="$ShowCases.Count" data-link="{$Link}AjaxGetMore">Show More</a> 
            
            <div class="content">
                $Content
            </div>    
        </div>
        <div class="clear"></div>
        
  </div>
</div>
