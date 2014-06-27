<!-- Sidebar Buttons -->
<div class="sidebarc2a-area">
    <% loop $SiteConfig.SideBarLinks %>
        <a class="sidebar-c2a" href="<% if $Blink %>$Blink.getLinkURL<% end_if %>">
            <span class="$IconClass"></span>
            <h5>$Blink.title</h5>
            <p>$Description</p>
        </a>
    <% end_loop %>
</div>