<div class="publication-chapter">

    <a href="<% if $File %>$File.URL<% else %>javascript:void(0)<% end_if %>" target="_blank" title="Name">
        <h3 class="chapter-title">$Title</h3>
    </a>
    
    <p class="abstract">$Abstract</p>
    
    <% if $Editors %>
        <p class="page editor"><span class="page-number">$Editors</span></p>
    <% end_if %>
    
    <% if $PageNumber %>
        <p class="page">
            <% if $CanShowVolumNo %><% loop $Parent.IssueAndVolume.first %>$issuenewTitle <br><% end_loop %><% end_if %>
            Page Number - <span class="page-number">$PageNumber</span>
        </p>
    <% end_if %>

</div>   