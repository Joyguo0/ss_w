<div class="large-12 columns no-pad white-content-area jagged" id="ugly-people">
    <div class="large-3 columns">
        <h4 class="red">OTHER UGLIES</h4>
    </div>
    <div class="large-9 columns">
        $Content
    </div>

    <div class="clear"></div>
    
    <% loop $Children %>
        <div class="large-3 small-6 columns">
            <div class="ugly-people $AmbassadorKey.Image.Title">
                <a href='$Link'>
                    $Image.CroppedImage(226,226)
                    <h3>$Name</h3>
                </a>
            </div>
        </div>
    <% end_loop %>
</div>

<div class="large-12 columns no-pad white-content-area jagged" id="ugly-people-key">
    <h5>AMBASSADOR KEY</h5>
    
    <% loop $SiteConfig.AmbassadorKeys %>
        <div class="large-1 small-6 columns">
            <img src="$Image.URL" alt="$Title">
        </div>
    <% end_loop %>
</div>