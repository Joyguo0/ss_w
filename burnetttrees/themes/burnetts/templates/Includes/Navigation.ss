<div class="nav-wrapper">
	<div class="row">
	
	    <nav class="top-bar" data-topbar>
	      <ul class="title-area">
	        <li class="name"><!-- Leave this empty --></li>
	        <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
	      </ul>
	      
	      <section class="top-bar-section">
	        <ul>
	        	
	        	<% loop $Menu(1) %>
	        		<% if $Children %>
	        		<li class="has-dropdown">
	        			<a href="$Link">$Title</a>
	        				<ul class="dropdown">
		        			<% loop $Children %>
					    		<li><a title="$Title" href="$Link">$Title</a></li>
					   		<% end_loop %>
					   		</ul>
	        			
	        		</li>
	        		<% else %>
	        			 <li><a href="$Link">$Title</a></li>
	        		<% end_if %>
	          	<% end_loop %>
				
				<div class="clear"></div>
				
	        </ul>
	      </section>
	      
	    </nav>
	    
	    <% if $SiteConfig.NavigationLink %>
			<% loop $SiteConfig.NavigationLink %>
				<a href="$redirectionLink" class="header-button" $TargetAttr>$Title</a>
			<% end_loop %>
		<% end_if %>
	    
	</div>
</div>