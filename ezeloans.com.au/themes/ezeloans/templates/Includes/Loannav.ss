 <div class="col3">

  <!-- Sidebar Navigation -->
    <div class="sidebarnav">
        <h5><a href="#">Other Loans</a></h5>
        <ul>
        <% loop LoanPages %>
            <li><a href="$Link">$Title</a></li>
        <% end_loop %>
           
        </ul>
    </div>

    <% include SideBarButton %>

    <div class="clear"></div>


</div>