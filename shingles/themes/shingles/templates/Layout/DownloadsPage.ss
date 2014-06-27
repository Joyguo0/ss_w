<% include BreadCrumbs %>
<div class="basic-content">
	<div class="onepcssgrid-1140">
        
        <!-- Content Bit -->
        <div class="col3">
        	<% include SlideBarshow justmenu=true %>
        	<div class="clear"></div>
        </div>
        <div class="col9 last">
        	<% if $Form || $Content %>
	        	<div class="content">
	        		$Form
	        	
	        		$Content
	        	</div>
        	<% end_if %>
        	<% if $DownloadFiles %>
        		<div class="downloads">
		        	<% loop $DownloadFiles %>
			            <div class="resource <% if MultipleOf(2)%>second<% end_if %> <% if MultipleOf(4)%>fourth<% end_if %>">
		                	<a href="$File.URL" title="$Link.Title" target="_blank">
		                    <h3>$Title</h3>
		                    <h5><% if $File.getFileType == Adobe Acrobat PDF file %>PDF<% end_if %> ($File.Size)</h5>
		                    <p>$Content</p>
		                </a>
		            </div>
		        	<% end_loop %>
	        	</div>
	        	<div class="clear"></div>
			<% end_if %>
        </div>
        
        
        <div class="clear"></div>
        
  </div>
</div>