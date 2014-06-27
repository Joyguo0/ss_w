<div class="row sub-banners">
	<% loop LoadPageBanners %>
		<div class="large-3 columns sub-box">
	      <a href="$redirectionLink" ><img alt="$Title" title="$Title" src="$Image.URL"></a>
	      $Content
	      <a href="$redirectionLink" >READ MORE &raquo;</a>
		</div>
	<% end_loop %>
</div>    

