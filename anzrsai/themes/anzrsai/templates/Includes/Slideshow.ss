
<!-- Slider -->
<% if LoadSlides %>

	<% if $Top.ClassName == HomePage %>
		<ul class="rslides">
	<% end_if %>
	
	<% loop LoadSlides %>
	
		<% if $Top.ClassName == HomePage %>
			<li>
		<% end_if %>
		
		<div id="about" class="row banner"
			style='
    			background: url("$ThemeDir/images/rays.png") no-repeat scroll 0 0px, 
			    		<% if CenterImage %>url("$CenterImage.URL") no-repeat scroll 50% 35%,<% end_if %> 
			    			url("$BackgroundImage.URL") no-repeat scroll 0 0 rgba(0, 0, 0, 0);'> 
		 
		    <% if $Top.ClassName == HomePage %>
				<% if Title %><h1 id="banner-top">$Title</h1><% end_if %>
				<% if Content %><h1 id="banner-bottom">$Content</h1><% end_if %>
			<% else %>
				<h1 id="banner">$Top.Title</h1>
			<% end_if %>
		</div>
		
		<% if $Top.ClassName == HomePage %>
			</li>
		<% end_if %>
		
    <% end_loop %>
    
    <% if $Top.ClassName == HomePage %>
		</ul>
	<% end_if %>
    
<% end_if %>



