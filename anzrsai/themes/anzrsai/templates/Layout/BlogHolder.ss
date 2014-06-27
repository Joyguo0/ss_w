<% include Slideshow %>
<% include BreadCrumbs %>	

$LoadJS

<div class="row" id="content">
     <div class="large-11 columns">
		 <p>$Content</p>
     </div>
         
         
     <% if BlogEntry %>
     
		<% loop BlogEntry %>
			<% include BlogSummary %>
		<% end_loop %>
		
	<% else %>
	
		<h2><% _t('BlogHolder_ss.NOENTRIES', 'There are no blog entries') %></h2>
		<% end_if %>
		
		<span class="ajaxcallback"></span>
        <div class="clear"></div>
        
        <% if ShowMoreButton %>
            <div class="col12">
                <div class="showmore">
                    <a id="showmore" href="javascript:void(0)"  class="blue-button" title="#"  data-start="$BlogEntry.Count" data-link="{$Link}AjaxGetMore"><span>Show More</span></a>
                </div>
            </div>
    <% end_if %>                            
 </div>     

