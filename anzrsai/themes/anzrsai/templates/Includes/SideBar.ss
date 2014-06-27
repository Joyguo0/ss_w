<% if $PageBannersSource != "Hide" %>
    <div class="large-3 small-12 columns">
    	<% if $Menu(2) %>
        	<ul class="side-nav">
    			<% include SidebarMenu %>                 
        	</ul>
    	<% end_if %>
    
    	<% if LoadPageBanners %>
    		<div class="large-3 columns sub-banners" id="side-banners">
    			<% loop LoadPageBanners %>
    			    <div class="large-12 columns sub-box">
    			    	<img alt="$Title" title="$Title" src="$Image.URL">
    			      	$Content
    			      	<a href="$redirectionLink">READ MORE &raquo;</a>
    			    </div>
    			<% end_loop %> 
    		</div>
    	<% end_if %>
    
    </div>
<% end_if %>
