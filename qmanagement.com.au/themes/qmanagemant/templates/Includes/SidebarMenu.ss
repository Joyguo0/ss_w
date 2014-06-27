<%--Include SidebarMenu recursively --%>

    <% if $Children %>
    <% loop $Children %>
    <li>
        <a href="$Link">
        $MenuTitle.XML
        </a>
    </li>
    <% end_loop %>

    <% end_if %>
