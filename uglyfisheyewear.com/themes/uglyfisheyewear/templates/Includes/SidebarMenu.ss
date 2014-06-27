<%--Include SidebarMenu recursively --%>

    <% if $Children %>
    <% loop $Children %>
    <li>
        <a href="$Link" title="Go to the $Title.XML page">
            <span class="text">$Title.XML</span>
        </a>

    </li>
    <% end_loop %>
    <% end_if %>
