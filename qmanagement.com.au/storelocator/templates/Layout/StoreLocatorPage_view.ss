<div class="typography" id="Layout">
	<h1>$Title</h1>
    <div class="content-basictext">
    	<% include BreadCrumbs %>
		
        <% loop Store %>
			<div id="content" class="contact-profile" style="width:540px;padding-top:0;">
				
				<div id="location-map">
					<a href="http://maps.google.com/maps?q=$FullAddress.URLATT" target="_blank">
						<img src="http://maps.google.com/maps/api/staticmap?sensor=false&size=530x250&markers=color:blue|$FullAddress.URLATT" alt="" />
					</a>
				</div>

				<div id="contact-details">
					<p>
						<% if Address %>$Address <% end_if %>
						<br><% if City %>$City <% end_if %><% if State %>$State <% end_if %><% if Postcode %>$Postcode<% end_if %>
					</p>
					<p>
						<% if ContactName %>Manager: $ContactName<% end_if %>
						<br><% if PhoneNumber %>Ph: $PhoneNumber<% end_if %>
						<% if FaxNumber %><br>Fax: $FaxNumber<% end_if %>
					</p>
					<p>
						<% if Email %>Email: <a href="mailto:$Email">$Email</a><% end_if %>
						<br><% if WebsiteName %>Website: <a href="$WebsiteUrl">$WebsiteName</a><% end_if %>
					</p>
				</div>
			</div>
		<% end_loop %>
		
		$Form
    </div>
    
    <% include RightColumn %>
</div>
