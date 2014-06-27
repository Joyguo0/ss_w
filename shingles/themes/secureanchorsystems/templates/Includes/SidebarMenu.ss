<% if $SiteConfig.SlideBarshows %>
	<% loop $SiteConfig.SlideBarShows %>
		<a href="$Link.LinkURL" title="$Title" class="sidebar-button <% if MultipleOf(2) %>last<% end_if %>">
        	<img src="$Image.CroppedImage(400,220).URL" alt="$Title" title="$Title" />
            <div class="caption">
            	<h5>$Title</h5>
            	<div class="fold"></div>
            </div>
        </a>
	<% end_loop%>
<% end_if %>