<div class="nav">
            <nav class="full-width">
                <ul class="navigation sf-menu">
	                <% loop $Menu(1) %>
						<li class="$LinkingMode <% if $ClassName != ShingleHolderPage && $Children %>yo<% end_if %>">
							<a href="$Link" title="$Title.XML">$MenuTitle.XML</a>
						
							
							<% if $Children && $ClassName == ShingleHolderPage %>
								<ul class="sf-mega">
								
									<% loop $GetShingleHolderPage(6) %>
										<li>
			                                <a href="$Link" title="Shingle Type">
			                                    <div class="drop-tabs">
			                                        $Photo.setSize(248,129)
			                                    </div>
			                                    <!-- <p>Shingle Type</p>-->
			                                    <p>$Title</p>
			                                </a>
			                            </li>
									<% end_loop %>
									
								</ul>
							<% else_if $Children && $ClassName == CaseHolderPage %>
								<ul>
									<% loop $GetCaseHolderPageSix %>
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
