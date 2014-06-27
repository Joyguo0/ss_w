<% if isMainSite && $AllProductCategories %>
    <!-- start main nav-->
    <div class="column" id="main-nav">
    <div class="row collapse">
        <div class="nav-drop hide">
            <a href=""><img src="$ThemeDir/images/button-mobile-nav.png" title="Menu" alt="Menu"></a>
        </div>
    
        <nav class="horizontal-nav small-hide">
            <ul class="menu sf-menu">
                <% loop $AllProductCategories %>
                    <li class="<% if $Children %>mega-menu<% end_if %>">
                        <a <% if Last %>id="sale"<% end_if %> href="$Link" class="">
                            <% if $SppMenuTitle %>$SppMenuTitle<% else %>$Title<% end_if %>
                        </a>
                        
                        <% if $Children %>
                            <ul class="drop-menu sf-mega">
                                <li>
                                    <div class="large-12 column">
                                        <% loop $Children %> 
                                            <ul class="<% if $CategoryNavColumnClass == 5 %>
                                            				<% if $First %>large-3
                                            				<% else_if $Last %>large-3
                                            				<% else %>large-2
                                            				<% end_if %>
                                            			<% else %>$CategoryNavColumnClass
                                            			<% end_if %> 
                                            			
                                            			small-12 column"
                                            >
                                                <li>
                                                    <h4><a href="$Link" alt="$Title">$Title</a></h4>
                                                    <% if $Children %>
                                                        <% loop $Children %> 
                                                        
                                                            <a href="$Link" alt="$Title">$Title</a>
                                                            
                                                            <% if $Desc %><span>Salt Water, Fresh Water</span><% end_if %>
                                                            
                                                        <% end_loop %>
                                                    <% end_if %>    
                                                </li>
                                            </ul>
                                        <% end_loop %>
                                    </div>                                                                                                                                                                                 
                                </li>
                            </ul>                            
                        <% end_if %>
                    </li>
                <% end_loop %>
            </ul>
        </nav>
    <!-- end main nav-->
    </div>
    </div>
<% end_if %>