<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">

	<% include SideBar %>	

	<div class="large-9 columns">
		<h2>$Title</h2>
			 <h6>$Date.format(F jS Y)</h6>
	<!--	<div class="flex-video">
					<iframe width="560" height="315" src="//www.youtube.com/embed/ScMzIvxBSi4?rel=0" frameborder="0" allowfullscreen></iframe>			 
			</div> -->
			$Content
			<div class="share-buttons">
				<div class="large-2 columns">
					<% if PrevNextPage(prev) %>
						<a href="$PrevNextPage(prev)">&laquo; Previous</a>
					<% end_if %>
				</div>
				
				<div class="large-8 columns">
				<!-- SHARETHIS Button BEGIN -->
					<span class='st_facebook_hcount' displayText='Facebook'></span>
					<span class='st_twitter_hcount' displayText='Tweet'></span>
					<span class='st_linkedin_hcount' displayText='LinkedIn'></span>
					<span class='st_email_hcount' displayText='Email'></span>
					<span class='st_sharethis_hcount' displayText='ShareThis'></span>
				<!-- SHARETHIS Button END -->
				</div>
				<div class="large-2 columns">
					<% if PrevNextPage %>
						<a href="$PrevNextPage(next)">Next &raquo;</a>
					<% end_if %>
				</div>
			 </div>
			 
	   <% include ResourcesBox %>
	</div>
		 
</div>