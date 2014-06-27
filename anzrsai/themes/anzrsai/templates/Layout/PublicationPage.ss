<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
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
	
			<li class="end">
				<a href="{$Link}archive/" class="archive" title="Go to the archive page">
					<span class="arrow">&rarr;</span>
					<span class="text">Archive</span>
				</a>
			</li>
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
		<h2>$Title</h2>
		$Content
		
		<% if $Children %>
		<% loop $children %>
		
			<% if $ClassName != PublicationVolume %>
				<a href="$Link" class="$LinkingMode pub-title" title="$Title.XML"><span class="text">$MenuTitle.XML</span></a>
				<div class="pub-content">$Content</div>
			<% end_if %>
			
		<% end_loop %>
		<% end_if %>
		
		<!--  input the sub page (5 = 2 + 3) -->
		
	</div>     
</div>

