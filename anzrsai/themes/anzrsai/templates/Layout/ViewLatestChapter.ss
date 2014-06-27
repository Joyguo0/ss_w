<% include Slideshow %>
<% include BreadCrumbs %>   

<div class="row" id="content">
	
    <% include SideBar %>

	<% if $PageBannersSource != "Hide" %>
	   <div class="large-9 columns">
	<% else %>
	   <div class="large-12 columns">		
	<% end_if %>	
	
	<h2>$Title </h2>
	
		<% if $LatestChapter(20) %>
			<% loop $LatestChapter(20) %>
			     
			     <% if $CanViewLatestChapter %>
			         <% include ChapterItem CanShowVolumNo=1 %>
			     <% end_if %>
			     
			<% end_loop %>
		<% end_if %>
		
	</div>

</div>