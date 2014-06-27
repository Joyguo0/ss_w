<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">

    <h1>UGLY PEOPLE</h1>

    <div class="large-12 columns no-pad white-content-area jagged" id="ugly-people">
        <div class="large-3 columns">
            <h4 class="red">$Title</h4>
            
            <% if $YoutubeLink %>
                <iframe width="360" height="315" frameborder="0" allowfullscreen="" src="$YoutubeLink.getLinkURL"></iframe>
            <% else_if $Image %>
                $Image.CroppedImage(360,315)
            <% end_if %>
            
        </div>
        
        <div class="large-9 columns">

            $Content
            
        </div>

        <div class="clear"></div>

    </div>

    <% loop $Parent %>
        <% include UglyPeopleHolderContent %>
    <% end_loop %>

</div>
</div>
