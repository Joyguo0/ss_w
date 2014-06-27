<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">

    <div class="large-9 small-12 columns push-3 no-pad-right white-content-area news-article" id="right-col">
        <h1>$Title
            <span class="float-right small">$Date.format("d/m/Y")</span>
        </h1>
        <% if $Image.exists() %>
        <div id="news-feature-image">
            <img src="$Image.URL">
        </div>
        <% end_if %>$Content

        <div class="large-12 share column news-end">
            <div class="large-8 push-2 small-12 columns">
                <span class='st_facebook_hcount' displayText='Facebook'></span>
                <span class='st_twitter_hcount' displayText='Tweet'></span>
                <span class='st_googleplus_hcount' displayText='Google +'></span>
            </div>
            <div class="large-2 small-6 pull-8 column">
                <a href="$PrevNextPage(prev)" class="button small-button red-button next previous float-left">&laquo; PREVIOUS</a>
            </div>
            <div class="large-2 small-6 column">
                <a href="$PrevNextPage(next)" class="button small-button red-button next float-right">NEXT &raquo;</a>
            </div>
        </div>


    </div>
    <div class="large-3 small-12 column pull-9 no-pad-left" id="left-col">
        <% include SideBar %>
    </div>
</div>
