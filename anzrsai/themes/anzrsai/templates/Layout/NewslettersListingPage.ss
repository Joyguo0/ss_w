<% include Slideshow %>
<% include BreadCrumbs %>   
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">
    <div class="large-3 small-12 columns">
        <% include SideBar %>
    </div>

    <div class="large-9 columns">
        <h2 class="chapter-title">$Title</h2>
        
        $Content
        
        <% if $Newsletters %>
            <% loop $Newsletters.sort('"Sort" DESC') %>
                <div class="publication-chapter">
                
                    <a href="<% if $File %>$File.URL<% else %>javascript:void(0)<% end_if %>" target="_blank" title="$Title">
                        <h3 class="chapter-title">$Title</h3>
                    </a>
                
                </div>    
            <% end_loop %>
        <% else %>
           <p>There is no newsletters.</p>
        <% end_if %>    
        
    </div>     
</div>

