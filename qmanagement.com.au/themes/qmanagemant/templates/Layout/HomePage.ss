<div class="hero-wrapper">
    <div class="hero-slider royalSlider rsDefault">
        <% if $Gallerys %>
        <% loop $Gallerys %>
        <div class="hero-panel rsContent" style="background:url('$Image.URL()');">
            <div class="hero-box-row row">
                <div class="hero-box large-5 rsCaption">
                    <div class="swish"></div>
                    <h3>$Title</h3>
                    <p>$Content</p>
                    <a href="$Link.getLinkURL" class="readmore">Read More</a>
                </div>
            </div>
        </div>
        <% end_loop %>
        <% end_if%>
    </div>
</div>
<div class="row">
    <div class="large-12 columns">
        <ul class="small-block-grid-1 medium-block-grid-2">
            <% if $Banners %>
            <% loop $Banners %>
            <li class="building-box">
                <a href="$Link.getLinkURL">
                    <img src="$Image.URL()" alt="">
                </a>
                <div class="box-desc rsCaption">
                    <h3>$Link</a>
                    </h3>
                    <p>$Content</p>
                    <a href="$Link.getLinkURL" class="readmore">Read More</a>
                </div>
            </li>
            <% end_loop %>
            <% end_if%>
        </ul>
    </div>
</div>

<% include Map %>
