<div class="aboveheader">
	<div class="onepcssgrid-1140">
    	<div class="col12">
        	<% loop $SubSiteList %>
        		<a href="http://{$Domain}" class="ah-tab<% if $Current %> opened<% end_if %>" title="$Title">$Title</a>
			<% end_loop %>
        </div>
        <div class="clear"></div>
    </div>
</div>
<header>
    <div class="onepcssgrid-1140">
    
    	<div class="col6">
        	<a href="/home" class="logo">
        		$SiteConfig.HeaderLogo
            </a>
        </div>

        
        <% loop SearchForm %> 
    		<div class="search-side col6 last">
	        	<form class="header-search" $FormAttributes>
	              	<input class="search-box" type="text" placeholder="Search..." name="Search">
	                <input class="search-glass" type="submit">
	                
	            </form>
	        </div>
		<% end_loop %>
            
        <div class="clear"></div>
                     
        
	</div>    
</header>
<!-- Navigation -->
        <% include Navigation %>