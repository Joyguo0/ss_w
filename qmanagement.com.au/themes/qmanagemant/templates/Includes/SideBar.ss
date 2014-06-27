<div class="sidebar large-3 large-pull-9 medium-4 medium-pull-8 columns">

    <% if $Menu(2) %>
    <ul class="side-nav">
        <% with $Level(1) %>
        <li><a href="$Link">$MenuTitle</a>
        </li>

        <% include SidebarMenu %>

        <% end_with %>
    </ul>
    <% end_if %>


    <% if LoadPageBanners %>
    <% loop $LoadPageBanners.limit(2) %>
    <div class="sidebox" style="background-image:url($Image.URL())">
        <a href="<% if $Link %>$Link.getLinkURL<% end_if %>"></a>
        <div class="sidebox-overlay"></div>
        <div class="sidebox-inner">
            <span class="findout">Find Out More</span>
            <h4>$Title</h4>
            <span>$Content</span>
        </div>
    </div>

    <% end_loop %>
    <% end_if %>
</div>
