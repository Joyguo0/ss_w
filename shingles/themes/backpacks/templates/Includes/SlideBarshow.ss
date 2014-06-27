<% if $Children %>
	<div class="sidebar-menu">
		<div class="title-bar">
	    	<h5>$MenuTitle.XML</h5>
	    </div>
	    <div class="clear"></div>
	    <!-- <a class="go" href="#">Go &raquo;</a> -->
	    <ul>
	        <% if $Children && $ClassName == ShingleHolderPage %>
	        	<% loop $GetShingleHolderPage(6) %>
	        		<li><a title="$Title" href="$Link">$Title</a></li>
	       		<% end_loop%>
	        <% else_if $Children && $ClassName == CaseHolderPage %>
				<% loop $GetCaseHolderPageSix %>
	        		<li><a title="$Title" href="$Link">$Title</a></li>
	       		<% end_loop%>
	       	<% else_if $Children && $ClassName != ShingleHolderPage && $ClassName != ShingleHolderPage %>
				<% loop $Children %>
	        		<li><a title="$Title" href="$Link">$Title</a></li>
	       		<% end_loop%>
			<% end_if%>
	    </ul>
	</div>
<% end_if %>

<ul class="shingletypes">
	<li class="head"><h5>Shingle Types:</h5></li>
	<% loop GetShingleHolderPage(6) %>
        <li><a href="$Link" title="$Title">$Title</a></li>
	<% end_loop%>
</ul>

<% if $SiteConfig.SlideBarshows %>
	<% loop $SiteConfig.SlideBarShows %>
		<a href="$Link.LinkURL" title="$Title" class="sidebar-button">
        	$Image.setSize(400,220)
            <div class="caption">
            	<h5>$Title</h5>
            	<div class="fold"></div>
            </div>
        </a>
	<% end_loop%>
<% end_if %>

<div class="showcase-menu">
	<h3>Showcase</h3>
	<div class="break"></div>
	<ul>
	
		<% loop $GetCaseHolderPageThree %>
			<li>
		    	<a href="$Link" title="Showcase Item">
		            $Photo.setSize(300,225)
		            <div class="textright">
		                <h6>$Title</h6>
		                <p>$Content.LimitCharacters(20)</p>
		            </div>
		            <div class="clear"></div>
		        </a>
		    </li>
		<% end_loop%>
		
	</ul>
	<div class="break"></div>
</div>