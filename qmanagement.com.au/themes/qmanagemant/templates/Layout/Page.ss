<div class="content-wrapper">
    <div class="row">
        <div class="content large-9 large-push-3 medium-8 medium-push-4 columns">
            $Content $Form
            <ul class="associated-resources">

                <% if $Resources %>
                <% loop $Resources %>
                <li class="building-box">

                    <a href="$File.Link">
                        <img src="$File.Icon">
                        <h1>$Title</h1>
                        <p class="resource-info">$File.getSize() $File.getFileType()</p>
                        <p class="resource-description">$Content</p>
                        <div class="clear"></div>
                    </a>

                </li>
                <% end_loop %>

                <% end_if%>


            </ul>
        </div>

        <% include SideBar %>

    </div>
</div>
