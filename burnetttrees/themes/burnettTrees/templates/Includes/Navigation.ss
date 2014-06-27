<div class="nav-wrapper">
	<div class="row">
	    <a href="#" class="button order-btn main-btn radius show-for-large-up">Order Now!</a>
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

	        </ul>
	      </section>
	      
	    </nav>
	</div>
</div>