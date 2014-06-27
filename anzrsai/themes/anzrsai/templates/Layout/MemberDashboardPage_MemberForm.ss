<% include Slideshow %>
<% include BreadCrumbs %>   

<div class="row" id="content">
	<div class="large-10 large-offset-1 column">
	<h2>$Title</h2>
		$Content
		<% if MemberForm %>
			$MemberForm
		<% else %>
			$Form
		<% end_if %>
		
	</div>
	<% include MemberBanners %>
</div>