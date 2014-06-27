<div class="locations">
    <div class="row">
        <div class="large-4 columns">
            <span class="findout">Our Locations</span>
            <h3>$Title</h3>
            <p>$Content</p>
        </div>
        <div class="large-8 columns">
            <% include Map %>
        </div>
    </div>
</div>

<div class="content-wrapper-white">
    <div class="row">
        <div class="large-12 columns">
            <ul class="small-block-grid-1 medium-block-grid-2">
                <% if $getOneBuilding %>
                <% loop $getOneBuilding %>
                <li class="building-box">
                    <a href="$BuildingListLink">
                        <img src="$Image.URL()" alt="">
                    </a>
                    <div class="box-desc rsCaption">
                        <h3><a href="$BuildingListLink">$Title</a>
                        </h3>
                        <p>$Content</p>
                        <a href="$BuildingListLink" class="readmore">Read More</a>
                    </div>
                </li>
                <% end_loop %>
                <% end_if%>
                <% if $getOneBuilding( 'upcoming') %>
                <% loop $getOneBuilding( 'upcoming') %>
                <li class="building-box">
                    <a href="$BuildingListLink">
                        <img src="$Image.URL()" alt="">
                    </a>
                    <div class="box-desc rsCaption">
                        <h3><a href="$BuildingListLink">$Title</a>
                        </h3>
                        <p>$Content</p>
                        <a href="$BuildingListLink" class="readmore">Read More</a>
                    </div>
                </li>
                <% end_loop %>
                <% end_if%>

            </ul>
        </div>
    </div>
</div>
