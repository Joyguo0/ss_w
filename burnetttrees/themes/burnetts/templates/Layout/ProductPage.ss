
<div class="row">
        <div class="large-12 columns">
            <h1 class="page-title">$Title</h1>
            <!-- <h1>${$Price}</h1> -->
            <% include BreadCrumbs %>
        </div>
</div>
<div class="row">
        <div class="large-3 columns show-for-large-up">
            <!--
            -->
            <% include SlideBarshow %>
        </div>
        <div class="large-9 columns">
            <% if $Introductory %>
	            <div class="article-tag row columns">
	                $Introductory
	            </div>
            <% end_if %>
            <div class="row">
                <div class="article large-8 columns">
                
                	<% if $ProductTabs %>
						<% loop $ProductTabs %>
                			<% if $First %>
			                    <dl class="tabs" data-tab>
							<% end_if %>
			                  
									<dd <% if $First %> class="active" <% end_if %> ><a href="#panel2-$Pos">$Title</a></dd>
									
			              	<% if $Last %>
			                    </dl>
			                <% end_if %>   
			            
						<% end_loop %>
					<% end_if %>
					
					<% if $ProductTabs %>
						<% loop $ProductTabs %>
							<% if $First %>
								<div class="tabs-content">
							<% end_if %>
									<div class="content <% if $First %> active <% end_if %>" id="panel2-$Pos">
										<p>{$Content}</p>
									</div>
							<% if $Last %>
			                    </div>
			                <% end_if %>  
						<% end_loop %>
					<% end_if %>
                </div>
                
                
                <div class="images large-4 columns">
                	
                    <% loop $LoadPageBanners %>
					      <img alt="$Title" title="$Title" src="$Image.URL">
					<% end_loop %>
                </div>
            </div>
        </div>
</div>