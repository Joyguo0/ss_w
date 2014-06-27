<% include BreadCrumbs %>

<div class="basic-content">
	<div class="onepcssgrid-1140">
	
		<div class="col3">
        	
            <% include SlideBarshow %>
            <div class="clear"></div>
            
        </div>
        
		<div class="col6">
        	<div class="content">
	        	<% if $Form %>
					<% loop $Form %> 
						<form $AttributesHTML>
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
						                        <input type="checkbox" name="$Up.Name"><label>$Title</label>
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
				
				
				<% include MapContent %>
				
				
			</div>
		</div>
		
		<div class="col3 last">
        	<div class="content">
				$Content
			</div>
		</div>
        
        <div class="clear"></div>
	</div>
</div>

