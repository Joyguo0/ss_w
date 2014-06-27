<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 

<div id="Content" class="row">
	<div class="large-3 small-12 columns">
		<% if $Menu(2) %>
		<ul class="side-nav">
			<% with $Level(1) %>
			
				<% if LinkOrSection = section %>
					<% if $Children %>
						<% loop $Children %>
							<% if $ClassName != PublicationVolume %>
								<li <% if Last %> class="end" <% else %>class="$LinkingMode"<% end_if %>>
									<a href="$Link" class="$LinkingMode" title="Go to the $Title.XML page">
										<span class="arrow">&rarr;</span>
										<span class="text">$MenuTitle.XML</span>
									</a>
								</li>
							<% end_if %>
						<% end_loop %>
					<% end_if %>
				<% end_if %>    
			<% end_with %>                  
		
		<% end_if %>
	
		
			<li class="end journal-search">
				<h4>Journal Search</h4>
				<p>Search by keywords, editors, volume number, issue number or chapter title</p> 
				<% if $MySearchForm %>
					<% loop $MySearchForm %> 
						<form $AttributesHTML style=>
							<% if $Message %>
								<p id="{$FormName}_error" class="message $MessageType">$Message</p>
							<% else %>
								<p id="{$FormName}_error" class="message $MessageType" style="display: none"></p>
							<% end_if %>
							
							<fieldset>
								<% loop $Fields %>
									<% if $LoadClassName == OptionsetField %>
										<label for="$ID">$Title</label>
										<% loop $LoadSource %>
						                    <div class="contact-options">
						                        <input type="radio" name="$Name" value="$Value" id="$ID"><label for="$ID">$Title</label>
						                    </div>
										<% end_loop %>
									<% else_if $LoadClassName == CheckboxSetField %>
										<label for="$ID">$Title</label>
										<% loop $LoadSource %>
						                    <div class="contact-options">
						                        <input type="checkbox" name="{$Up.Name}[{$Value}]" value="$Value" id="$ID"><label for="$ID">$Title</label>
						                    </div>
										<% end_loop %>
									<% else %>
										$FieldHolder
									<% end_if %>
								<% end_loop %>
							</fieldset>
								
							<% loop $Actions %>
								$Field
							<% end_loop %>
						</form>
						<% end_loop %>
				<% end_if %>
			</li>
		</ul>
	</div>
			
	<div class="large-9 columns">
		<h1>$Title</h1>

		<% if $Query %>
			<p class="searchQuery">You searched for &quot;{$Query}&quot;</p>
		<% end_if %>
	
		<% if $Results %>
			<ul id="SearchResults">
				<% loop $Results %>
				<li>
					<h4>
						<a href="$Link">
							<% if $MenuTitle %>
							$MenuTitle
							<% else %>
							$Title
							<% end_if %>
						</a>
					</h4>
					<% if $Content %>
						<p>$Content.LimitWordCountXML</p>
					<% end_if %>
					<a class="readMoreLink" href="$Link" title="Read more about &quot;{$Title}&quot;">Read more about &quot;{$Title}&quot;...</a>
				</li>
				<% end_loop %>
			</ul>
		<% else %>
			<p>Sorry, your search query did not return any results.</p>
		<% end_if %>
	
		<% if $Results.MoreThanOnePage %>
			<div id="PageNumbers">
				<div class="pagination">
					<% if $Results.NotFirstPage %>
					<a class="prev" href="$Results.PrevLink" title="View the previous page">&larr;</a>
					<% end_if %>
					<span>
						<% loop $Results.Pages %>
							<% if $CurrentBool %>
							$PageNum
							<% else %>
							<a href="$Link" title="View page number $PageNum" class="go-to-page">$PageNum</a>
							<% end_if %>
						<% end_loop %>
					</span>
					<% if $Results.NotLastPage %>
					<a class="next" href="$Results.NextLink" title="View the next page">&rarr;</a>
					<% end_if %>
				</div>
				<p>Page $Results.CurrentPage of $Results.TotalPages</p>
			</div>
		<% end_if %>
	</div>	
</div>
