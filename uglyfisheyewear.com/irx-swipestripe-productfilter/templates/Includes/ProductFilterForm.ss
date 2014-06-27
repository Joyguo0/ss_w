<span class="psbf">
    
    <div id="selected-filter-head" class="large-12 column">
        <h3 class="white">REFINE BY:</h3>
        <a href="$Controller.Link" class="clear-all button white-button small-button">CLEAR ALL</a>
    </div>
    
    
    <div id="selected-filter" class="large-12 column">
        <% if $Fields %>
            <% loop $Fields %>
            	<% loop $Items %>
            		<% loop $Options %>
	                	<% if not $Link %>
	                		<a href="$DeleteLink">$Up.Title - $Title<span></span></a>    
	                	<% end_if %>
                	<% end_loop %>
            	<% end_loop %>
            <% end_loop %>
        <% end_if %>
    </div>
    
    
    <ul id="menu" class="product-filter">
    
        <% if $Controller.ChildrenCategories %>
            <li class="active">
                <a href="$Link">Sub-categories<span class="arrow"></span></a>
                
                <ul>
                    <% loop $Controller.ChildrenCategories %>
                        <li class="$LinkingMode">
                            <a href="$Link">$Title.XML</a>
                        </li>
                    <% end_loop %>
                </ul>
            </li>
        <% end_if %>
    
        <% if $LoadProductSidebarCategories %>
            <% loop $LoadProductSidebarCategories %>
                <li class="<% if $IsOpened %>active<% end_if %>">
                    <a href="$Link">$Title.XML<span class="arrow"></span></a>
                    
                    <% if $Children %>
                        <ul>
                            <% loop $Children %>
                                <li><a href="$Link"><span class="list-checkbox"></span>$Title.XML<span>$AF_OptionProductCount</span></a></li>
                            <% end_loop %>
                        </ul>
                    <% end_if %>        
                </li>
            <% end_loop %>
        <% end_if %> 
        
        <% if $Fields %>
            <% loop $Fields %>
                
                $FieldHolder
                
            <% end_loop %>
        <% end_if %>
                                                                                              
    </ul>
</span>