<div class="content-wrapper-white">
    <div class="row">
        <div class="large-12 columns">
            <ul class="small-block-grid-1 medium-block-grid-2">

                <% if $Buildings %>
                <% loop $Buildings %>
                <li class="building-box">
                    <a href="$Link">
                        <img src="$Image.URL()" alt="">
                    </a>
                    <div class="box-desc rsCaption">
                        <h3><a href="$Link">Building 1</a>
                        </h3>
                        <p>$Content</p>
                        <a href="$Link" class="readmore">Read More</a>
                    </div>
                </li>
                <% end_loop %>

                <% end_if%>
            </ul>
        </div>
    </div>
</div>
