<% include Slideshow %>
<% include BreadCrumbs %>	

<div class="row" id="content">

	<div class="large-12 columns start last">
        <div class="forum-header large-9 column start">
        	
        	<h1 class="forum-heading"><a name='Header'>$HolderSubtitle</a></h1>
        	<!-- hide breadcrumbs for forum
        		<p class="forum-breadcrumbs">$Breadcrumbs</p>
        	-->	
        	<p class="forum-abstract">$ForumHolder.HolderAbstract</p>
        	
        	<% loop ForumHolder %>
        		<div class="forum-header-forms">
        			
        			<% if NumPosts %>
        				<p class="forumStats">
        					$NumPosts 
        					<strong><% _t('ForumHeader_ss.POSTS','Posts') %></strong> 
        					<% _t('ForumHeader_ss.IN','in') %> $NumTopics <strong><% _t('ForumHeader_ss.TOPICS','Topics') %></strong> 
        					<% _t('ForumHeader_ss.BY','by') %> $NumAuthors <strong><% _t('ForumHeader_ss.MEMBERS','members') %></strong>
        				</p>
        			<% end_if %>
        		</div>
        </div>			
		<div class="forum-finder large-3 column last">
			<span class="forum-search-dropdown-icon"></span>
			
			<form class="forum-jump large-12 column last" action="#">
				<label for="forum-jump-select"><% _t('ForumHeader_ss.JUMPTO','Jump to:') %></label>
				<select id="forum-jump-select" onchange="if(this.value) location.href = this.value">
					<option value=""><% _t('ForumHeader_ss.JUMPTO','Jump to:') %></option>
					<!-- option value=""><% _t('ForumHeader_ss.SELECT','Select') %></option -->
					<% if ShowInCategories %>
						<% loop Forums %>
							<optgroup label="$Title">
								<% loop CategoryForums %>
									<% if can(view) %>
										<option value="$Link">$Title</option>
									<% end_if %>
								<% end_loop %>
							</optgroup>
						<% end_loop %>
					<% else %>
						<% loop Forums %>
							<% if can(view) %>
								<option value="$Link">$Title</option>
							<% end_if %>
						<% end_loop %>
					<% end_if %>
				</select>
			</form>			
			
			<div class="forum-search-bar large-12 column last">
				<form class="forum-search" action="$Link(search)" method="get">
					<fieldset>
						<label for="search-text"><% _t('ForumHeader_ss.SEARCHBUTTON','Search') %></label>
						<input id="search-text" class="text active" type="text" name="Search" value="$Query.ATT" />
						<input class="submit action" type="submit" value="<% _t('ForumHeader_ss.SEARCHBUTTON','Search') %>"/>
					</fieldset>	
				</form>
			</div>
			
			<div class="clear"></div>
        			
       </div><!-- forum-header-forms. -->
	<% end_loop %>
	
		
	<% if Moderators %>
		<p>
			Moderators: 
			<% loop Moderators %>
				<a href="$Link">$Nickname</a>
				<% if not Last %>, <% end_if %>
			<% end_loop %>
		</p>
	<% end_if %>

</div><!-- forum-header. -->
