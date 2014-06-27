<% if getHeaderName()==HomePage||getHeaderName()==LandingPage  %>
<% else %>
<% include Banner %>
<% end_if %>

<!-- White Area -->
<div class="white-area">


    <div class="onepcssgrid-1140">
        <div class="main-area">
            <div class="col3">

                <% include SidebarMenu %>
                
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
                <div class="content typography">
                    <% if ClassName==FaqPage  %>
                        <% include Faq %>
                    <% end_if %>                  
                    $Content
                    $Form
                    $PageComments
                </div>
            </div>
        </div>
    </div>

 	
    <div class="clear"></div>	
</div>
