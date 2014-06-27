<% include Slideshow %>
<% include BreadCrumbs %>   

<div class="row" id="content">
	<div class="large-10 large-offset-1 column" id="member-dashboard">
	<h2>Welcome <% with currentUser %>$FirstName $Surname <% end_with %></h2>
		$Content
		$Form	
		<% include MemberBanners %>
	</div>	
</div>