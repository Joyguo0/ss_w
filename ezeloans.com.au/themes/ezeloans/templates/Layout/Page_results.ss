<% if getHeaderName()!=HomePage  %>
<% include Banner %>
<% end_if %>

<!-- White Area -->
<div class="white-area">


    <div class="onepcssgrid-1140">
        <div class="main-area">
            <div class="col3">
                <!-- Sidebar Navigation -->
                <div class="sidebarnav">
                    <h5><a href="#">$Title</a></h5>
                    <ul>
                         <% include SideBar %>
                    </ul>
                </div>
                <% include SideBarButton %>
                <!-- Loans Listing -->
                <ul class="loans-listing">
                    <% loop LoanPages %>
                        <li class="$IconClass <% if $Even  %>second<% end_if %>">
                            <a href="$Link"><span></span>$Title</a>
                        </li>
                    <% end_loop %>

                    <div class="clear"></div>
                </ul>

                <div class="clear"></div>
            </div>
            <div class="col9 last">

              <!-- Search Results -->
                <% if $Results %>
                <ul class="search-results">
                    <% loop $Results %>
                        <li>
                            <a class="title" href="$Link">$Title</a>
                            <p>$Content.LimitWordCountXML</p>
                            <a class="moreinfo" href="$Link" title="$Title">Read more »</a>
                        </li>
                    <% end_loop %>
                </ul>
                <% else %>
                    <p>Sorry, your search query did not return any results.</p>
                <% end_if %>

               <% if $Results.MoreThanOnePage %>
                <div id="pagination" class='pagination'>
                        <% if $Results.NotFirstPage %>
                        <a class="prev" href="$Results.PrevLink" title="View the previous page">Previous</a>
                        <% end_if %>
                      
                            <% loop $Results.Pages %>
                                <% if $CurrentBool %>
                                 <span> $PageNum </span>
                                <% else %>
                                <a href="$Link" title="View page number $PageNum" class="go-to-page">$PageNum</a>
                                <% end_if %>
                            <% end_loop %>
                       
                        <% if $Results.NotLastPage %>
                        <a class="next" href="$Results.NextLink" title="View the next page">Next</a>
                        <% end_if %>
                    </div>

                <% end_if %>

            </div>
        </div>
    </div>

    
    <div class="clear"></div>   
</div>
