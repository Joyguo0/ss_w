<div class="row sub-banners members-area">
	<% loop LoadPageBanners %>
		<div class="large-3 columns sub-box">
	       <img alt="$Title" title="$Title" src="$Image.URL">
	       $Content
	       <a href="$redirectionLink" >$Title &raquo;</a>
		</div>
	<% end_loop %>
</div>    

