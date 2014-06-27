<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
	<div class="large-3 small-12 columns">
		<% if $Menu(2) %>
		<ul class="side-nav">
			<% with $Level(1) %>
			
				<% if LinkOrSection = section %>
					<% if $Children %>
						<% loop $Children %>
							<% if $ClassName != PublicationVolume %>
								<li <% if Last %> class="end" <% else %>class="$LinkingMode"<% end_if %>>
									<a href="$Link" class="$LinkingMode" title="Go to the $Title.XML page">
										<span class="arrow">&rarr;</span>
										<span class="text">$MenuTitle.XML</span>
									</a>
								</li>
							<% end_if %>
						<% end_loop %>
					<% end_if %>
				<% end_if %>    
			<% end_with %>                  
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



	<div class="large-9 columns">
		<h2>$Title</h2>
		$Content
		
		<!--  input the sub page (5) -->
		
		<% if $getVolume %>
		<% loop $getVolume %>
			
			<a href="$Link" class="$LinkingMode" title="Go to the $Title page">$Title</a>
			<br>
				$Content
			<br>
			
		<% end_loop%>
		<% end_if%>
		<!--  end the sub page (5) -->
		
		$Form
	</div>     
</div>

