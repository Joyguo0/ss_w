<% if $LoadResources %>
    <div class="res-box">
        <% loop $LoadResources %>
            <a href="$File.URL" target="_blank" class="pdf-button">$Title</a>
        <% end_loop %>            
    </div>
<% end_if %>