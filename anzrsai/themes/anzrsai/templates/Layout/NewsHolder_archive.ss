<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
	<% include SideBar %>
	<div class="large-9 columns">
		<div class="large-11 columns">
		<h3 class="subtitle">$Title</h3>
			
				<div class="archive">
					<p>Years: 
						<% loop Years %>
							<% if Current %>
								<span>$Year</span><% if not $Last %> &middot;<% end_if %>
							<% else %>
								<a href="$Link">$Year</a><% if not $Last %> &middot;<% end_if %>
							<% end_if %>
						<% end_loop %>
					</p>
				</div>
			<% loop $ArchiveNews.GroupedBy(DateMonth) %>
				<h4>$DateMonth</h4>
				<ul>
					<% loop $Children %>
						<li><a href="$Link">$Title ($Date.format(d/m/Y))</a></li>
					<% end_loop %>
				</ul>
			<% end_loop %>
					
		</div> 
		
		<% include ResourcesBox %>
	</div>	 
</div>
