<% if $Children %>
	<div class="sidebar-menu">
		<div class="title-bar">
	    	<h5>$MenuTitle.XML</h5>
	    </div>
	    <div class="clear"></div>
	    <!-- <a class="go" href="#">Go &raquo;</a> -->
	    <ul>
	        <% if $Children && $ClassName == ShingleHolderPage %>
	        	<% loop $Children %>
	        		<li><a title="$Title" href="$Link">$Title</a></li>
	       		<% end_loop %>
	        <% else_if $Children && $ClassName == CaseHolderPage %>
				<% loop $GetCaseHolderPage(6) %>
	        		<li><a title="$Title" href="$Link">$Title</a></li>
	       		<% end_loop %>
	       	<% else_if $Children && $ClassName != ShingleHolderPage && $ClassName != ShingleHolderPage %>
				<% loop $Children %>
	        		<li><a title="$Title" href="$Link">$Title</a></li>
	       		<% end_loop %>
			<% end_if%>
	    </ul>
	</div>
<% else_if $getParentPage %>
	<div class="sidebar-menu">
		<div class="title-bar">
	    	<h5>$getParentPage.Title</h5>
	    </div>
	    <div class="clear"></div>
	    <!-- <a class="go" href="#">Go &raquo;</a> -->
	    <ul>
	    	<% if $getParentChildren %>
		        <% loop $getParentChildren %>
	        		<li class="$LinkingMode"><a title="$Title" href="$Link">$Title</a></li>
				<% end_loop %>
			<% end_if %>
	    </ul>
	</div>
<% end_if %>

<!--
<ul class="shingletypes">
	<li class="head"><h5>Shingle Types:</h5></li>
	<% loop $GetShingleHolderPage(9) %>
        <li><a href="$Link" title="$Title">$Title</a></li>
	<% end_loop%>
</ul>
-->

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

<% if $GetCaseHolderPage %>
<div class="showcase-menu">
	<h3>Showcase</h3>
	<div class="break"></div>
	<ul>
	
		<% loop $GetCaseHolderPage(3) %>
			<li>
		    	<a href="$Link" title="Showcase Item">
		    		<img src="$Image.CroppedImage(300,225).URL" alt="$Title" title="$Title" />
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
<% end_if %>