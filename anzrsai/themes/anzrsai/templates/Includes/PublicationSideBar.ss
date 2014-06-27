<ul class="side-nav">
    <% if $LoadAllIssuesByCategory %>
        <% loop $LoadAllIssuesByCategory %>
            <li class="$LinkingMode">
                <a href="$Link" class="$LinkingMode" title="Go to the $Title page">
                    <span class="arrow">&rarr;</span>
                    <% if $ClassName == PublicationIssue %>
                        <span class="text">$issuenewTitle</span>
                    <% else %>
                        <span class="text">$Title</span>
                    <% end_if %>
                </a>
            </li>
        <% end_loop %>
    <% end_if %>
</ul>