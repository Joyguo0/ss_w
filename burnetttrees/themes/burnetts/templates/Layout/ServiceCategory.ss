
<div class="row">
        <div class="large-12 columns">
            <h1 class="page-title">$Title</h1>
            <% include BreadCrumbs %>
        </div>
</div>
<div class="row">
        <div class="large-3 columns show-for-large-up">
            <!--
            -->
            <% include SlideBarshow %>
        </div>
        <div class="large-9 columns">
            <% if $Introductory %>
	            <div class="article-tag row columns">
	                $Introductory
	            </div>
            <% end_if %>
            
            <% if $getService %>
		        <% loop $getService %>
		        
					<% include ServiceList %>
	                
				<% end_loop %>
			<% end_if %>
			
			<span class="ajaxcallback"></span>
            <a href="javascript:void(0)" class="showmore" title="#" data-start="$getService.Count" data-link="{$Link}AjaxGetMore">Show More</a>
            
        </div>
</div>