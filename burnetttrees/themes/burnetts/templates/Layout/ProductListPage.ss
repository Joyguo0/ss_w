<div class="row">
    <div class="large-12 columns">
        <h1 class="page-title">$Title</h1>
        <% include BreadCrumbs %>
    </div>
</div>

<div class="row">
    <div class="large-3 columns show-for-large-up">
        <% include SlideBarshow %>
    </div>
    
    <div class="large-9 columns">
        <% if $Introductory %>
            <div class="article-tag row columns">
                $Introductory
            </div>
        <% end_if %>
        
       	<% if $getProduct %>
       	    <div class="row">
                <div class="large-12 columns">
                    <ul class="small-block-grid-2 medium-block-grid-3">
            	        <% loop $getProduct %>
            	        
            				<% include ProductList %>
                            
            			<% end_loop %>
			         </ul>
			     </div>
			</div>
		<% else %>
		  <p>Sorry. There is no product here.</p>	
		<% end_if %>
		
		<span class="ajaxcallback"></span>
        <a href="javascript:void(0)" class="showmore" title="#" data-start="$getProduct.Count" data-link="{$Link}AjaxGetMore">Show More</a>
    </div>
    
</div>