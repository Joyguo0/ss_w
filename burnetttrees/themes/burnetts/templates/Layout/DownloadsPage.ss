<div class="row">
    <div class="large-12 columns">
        <h1 class="page-title">$Title</h1>
        <% include BreadCrumbs %>
    </div>
</div>

<div class="row">
    <div class="large-3 columns show-for-large-up">
        <!--
        -->
        <% include SlideBarshow %>
    </div>
    <div class="large-9 columns">
        <% if $Content %>
            <div class="article-tag row columns">
                $Content
            </div>
        <% end_if %>
        
        
        <div class="row">
            <div class="large-12 columns">
                <% if $Resources %>
                    <ul class="small-block-grid-1 medium-block-grid-2">
                        <% loop $Resources %>
                            <li class="download">
                                <div class="download-inner">
                                    <a href="$File.URL"></a>
                                    <div class="small-4 columns">
                                        <img src="$ThemeDir/images/download-resource.jpg">
                                    </div>
                                    <div class="small-8 columns">
                                        <h5>$Title</h5>
                                        <div class="file-details">$File.Size | $File.Extension File</div>
                                        <p>$Content.Summary</p>
                                    </div>
                                </div>
                            </li>   
                        <% end_loop %> 
                    </ul>
                <% end_if %>
            </div>
        </div>
    </div>
</div>