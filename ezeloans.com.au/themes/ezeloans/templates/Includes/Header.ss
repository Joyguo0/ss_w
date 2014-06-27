<header class="<% if getHeaderName()==HomePage  %>home-header<% else %>header<% end_if %>">
	<div class="onepcssgrid-1140">
		<div class="col12">
			<!-- Logo -->
        	<a class="logo" href="/">
                <img src='$SiteConfig.Toplogo.url()'/>
            </a>
            
        	<!-- Search/Call -->
        	<div class="header-top">
            	<div class="call">
                	<h5>Call Us Now</h5>
                    <a href="tel:$SiteConfig.Tel">$SiteConfig.Tel</a>
                </div>
                
                <% if $SearchForm %>
                    <div class="head-search" id="mn-searchform">
                        <a class="mn-search" href="#SearchForm_SearchForm"><span></span></a>
                        <% loop $SearchForm %> 
                            <form $FormAttributes>
                                <fieldset>
                                	<div class="arrow"></div>
                                    <input class="search-box text" name="Search" type="text" size="40" value="" placeholder="Search..." />
                                    <input class="search-glass action" type="submit" value="" title="Search" id="action" name="action_results" />
                                </fieldset>
                            </form>
                        <% end_loop %>
                    </div>
                <% end_if %>
                <div class="clear"></div>
            </div>	
            <!-- Main Navigation -->
            <nav class="main-nav">
                <ul class="sf-menu">
			         <% include Navigation %>
                 </ul>
            </nav>
		</div>
		<div class="clear"></div>
	</div>
</header>
