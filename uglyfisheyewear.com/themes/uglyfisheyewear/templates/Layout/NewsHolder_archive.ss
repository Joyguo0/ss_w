<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">

    <div class="large-9 small-12 columns push-3 no-pad-right white-content-area news" id="right-col">
        <h1>ugly news</h1>
        <div class="archive">
            <p>Years:
                <% loop Years %>
                <% if Current %>
                <span>$Year</span>
                <% if not $Last %>&middot;
                <% end_if %>
                <% else %>
                <a href="$Link">$Year</a>
                <% if not $Last %>&middot;
                <% end_if %>
                <% end_if %>
                <% end_loop %>
            </p>
        </div>
        <% loop $ArchiveNews.GroupedBy(DateMonth) %>
        <h4>$DateMonth</h4>
        <ul>
            <% loop $Children %>
            <li><a href="$Link">$Title ($Date.format(d/m/Y))</a>
            </li>
            <% end_loop %>
        </ul>
        <% end_loop %>
    </div>
    <div class="large-3 small-12 column pull-9 no-pad-left" id="left-col">
        <% include SideBar %>
    </div>
</div>
