<div class="content-wrapper">
    <div class="row">
        <div class="content large-9 large-push-3 medium-8 medium-push-4 columns">

            <dl class="accordion" data-accordion="">
                <% if $Questions %>
                <% loop $Questions %>


                <dd class="">
                    <a href="#panel1b_$Pos">$Title</a>
                    <div id="panel1b_$Pos" class="content ">
                        $Content
                    </div>
                </dd>

                <% end_loop %>
                <% end_if%>

            </dl>
        </div>
        <% include SideBar %>
    </div>
</div>
