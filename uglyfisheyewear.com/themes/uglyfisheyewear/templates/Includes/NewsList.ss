<% loop News %>
<div class="large-4 small-12 column">
    <div class="news-container">
        <% if $Image.exists() %>
        <a href="$Link">
            <img src="$Image.URL()">
        </a>
        <% end_if %>
        <a href="$Link">
            <h3>$Title</h3>
        </a>
        <p>$Content.Summary ...</p>
        <div class="column">
            <p class="small time-stamp">$Date.format("d F Y")</p>
            <% if MoreEvents %>
            <a href="$Link" class="button small-button">Read more &raquo;</a>
            <% end_if %>
        </div>
    </div>
</div>
<% end_loop %>
