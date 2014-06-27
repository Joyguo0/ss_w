<div class="row" id="header">
    <div class="large-3 small-12 columns logo">
		<% include ResponsiveNavigation %>
        
		<a href="/">
			<img alt="ANZRSAIlogo" title="ANZRSAI logo" src="<% with SiteConfig %><% if $Logo %>$Logo.URL <% else %> $ThemeDir/images/logo.png <% end_if %><% end_with %>">
		</a>
    </div>  
    
     <div class="large-5  large-offset-1 small-12 columns top-nav">
     	<div class="large-block-grid-4 small-block-grid-4">
         	<ul class="large-block-grid-4 small-block-grid-4">
         	    $SiteConfig.ExtraHeaderLinks
         	
         	    <% if not CurrentMember %>      
                    <li class="right-border"><a href="$LoadSignUpPage.Link">Join</a></li>
                    <li><a href="$LoadSignInLink">Sign In</a></li>
         	    <% else %>
                    <li class="right-border"><a href="$LoadMemberDashBoardPage.Link">DashBoard</a></li>
					<li class=""><a href="/Security/logout">Logout</a></li>
                <% end_if %>    
            </ul>
        </div>    
     </div>
     <div class="large-3 small-12 last search-box">
	    <% with SearchForm %>
	        <form id="head-search" $FormAttributes>
	            <input type="text" class="search-input"  name="Search" placeholder="Search...">
            	<input type="submit" value="Search" class="search-button">
	        </form>
		<% end_with %>
     </div>  
     <div class="large-10 large-offset-2 last">
     	<% include Navigation %>
    </div>
</div>    
		