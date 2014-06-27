<div class="col12">
    <div class="dark-area">
        <div class="col<% if ClassName=UserDefinedForm  %>6<% else %>9<% end_if %>">
                
            <p style='font-size:24px;background: url($ThemeDir/images/arrow.png) no-repeat scroll 140px 0 rgba(0, 0, 0, 0);display:block;font-size:1'>$Title</p>
            <!-- Content -->
            <div class="content">
            	$Content            
            </div>
           <% if $Children %>
	            <div id="tab-container" class="tab-container">
	                <ul class='etabs'>
	                	<!-- Tab Titles: These need to match some tab content below -->
	                	<% loop $Children %>
					          <li class='tab'><a href="#tabs{$Pos}">$Title</a></li>
					    <% end_loop %>
	                </ul>
	                <% loop $Children %>
				        <div id="tabs{$Pos}">
		                	<div class="content">
		                	$Content
		                <% if hasAddress %>
		                	$AddressMap(600,500)
		                <% end_if %>	
		                    </div>
		                </div>
				    <% end_loop %>
	            </div>
			<% end_if %>
              
            <div class="clear"></div>
            
        </div>
        
         <div class="col<% if ClassName=UserDefinedForm %>6<% else %>3<% end_if %> last">
                	
            <!-- Sidebar Images -->
        	<ul class="sidebar-images">
        		<% if ClassName=UserDefinedForm %>
        			<% loop $Slideshows.limit(1) %>
	        			<li><a href="$Image.url()">$Image</a>
		            			<% if $Title %>
		            		 		<p>$Title</p>
		            			<% end_if %>
		            		</li>
				    <% end_loop %>
				<% else %>
					<% loop $Slideshows %>
	            		<li><a href="$Image.url()">$Image</a>
	            			<% if $Title %>
	            		 		<p>$Title</p>
	            			<% end_if %>
	            		</li>
			    	<% end_loop %>
				<% end_if %>
            </ul>
            <div class="clear"></div>
            
        </div>
       
        <div class="clear"></div>
        $Form
        <br/><br/><br/>
    </div>
  
    <% include LightArea %>
</div>
<div class="clear"></div>