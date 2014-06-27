<% if $Items %>
    <% loop $Items %>
        <li>
            <a href="#">$Title<span class="arrow"></span></a>
            
            <ul>
                <% loop $Options %>
                    <li class="<% if not $Link %>active<% end_if %>">
                        <a href="<% if $Link %>$Link<% else %>$DeleteLink<% end_if %>">
                            <span class="list-checkbox">
                                </span>$Title<span>
                                $OptionProductCount
                            </span>
                        </a>
                    </li>
                <% end_loop %>
            </ul>    
        </li>    
    <% end_loop %>
<% end_if %>