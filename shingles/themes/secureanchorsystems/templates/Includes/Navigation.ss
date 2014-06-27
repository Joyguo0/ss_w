
<!-- Navigation -->
<div class="nav-holder">

    <div class="onepcssgrid-1140">
        <div class="col12">
        
            <div class="nav">
                <nav class="full-width">
                    <ul class="navigation sf-menu">
            
                        <% loop $Menu(1) %>
						<li class="$LinkingMode">
							<a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
						
							
							<% if $Children && $ClassName == ShingleHolderPage %>
								<ul>
									<% loop $Children %>
										<li><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
									<% end_loop %>
								</ul>
								<!--
								<ul class="sf-mega">
								
									<% loop $GetShingleHolderPage(9) %>
										<li>
			                                <a href="$Link" title="Shingle Type">
			                                    <div class="drop-tabs">
			                                        $Photo.setSize(248,129)
			                                    </div>
			                                    <p>$Title</p>
			                                </a>
			                            </li>
									<% end_loop %>
									
								</ul>
								-->
							<% else_if $Children && $ClassName == CaseHolderPage %>
								<ul>
									<% loop $GetCaseHolderPage(6) %>
										<li><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
									<% end_loop %>
								</ul>
							<% else_if $Children %>
								<ul>
									<% loop $Children %>
										<li><a href="$Link" title="$Title.XML">$MenuTitle.XML</a></li>
									<% end_loop %>
								</ul>
							<% end_if %>
						</li>
					<% end_loop %>
                    </ul>
                </nav>
                <!-- End Navigation -->
                <div class="clear"></div>
            </div>
        
        </div>
        <div class="clear"></div>
    </div>
    
</div>