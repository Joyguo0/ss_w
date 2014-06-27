<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row" id="dashboard">


    <h1 class="text-center">My Account</h1>

    <div class="large-6 small-12 columns center no-pad-right account-section">

        <div class="large-12 ">
            <h2 class="text-center medium">DETAILS</h2>
            <table id="account-details">
                <tbody>
                    <tr>
                        <td class="details-left">First Name:</td>
                        <td>$Member.currentUser().FirstName</td>
                    </tr>
                    <tr>
                        <td class="details-left">Last Name:</td>
                        <td>$Member.currentUser().Surname</td>
                    </tr>
                    <tr>
                        <td class="details-left">Email Name:</td>
                        <td>$Member.currentUser().Email</td>
                    </tr>
                    <tr>
                        <td class="details-left">Password:</td>
                        <td>$Member.currentUser().Surname</td>
                    </tr>
                    <tr>
                        <td class="details-left">Password:</td>
                        <td>******</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <a href="$Link/editprofile" class="button small-button">EDIT</a>
    </div>
    <div class="clear"></div>
    <div class="large-6 small-12 center columns no-pad-right account-section">

        <div class="large-12">
            <h2 class="text-center medium">address book</h2>
            <table id="address-book">
                <thead>
                    <tr>
                        <th class="text-left">ADDRESS</th>
                        <th>BILLING</th>
                        <th>DELIVERY</th>
                    </tr>
                </thead>
                <tbody>
                    <% loop Addresses %>
                    <tr>
                        <td class="text-left cond">
                            <a href="account/editaddress/$ID">$Address $AddressLine2 $RegionName $City $State $PostalCode $CountryName</td></a>
                            <td>
                                <% if $ClassName=='Address_Billing' %>
                                <img src="$ThemeDir/images/icon-tick.png" alt="tick">
                                <% end_if %>
                            </td>
                            <td>
                                <% if $ClassName=='Address_Shipping' %>
                                <img src="$ThemeDir/images/icon-tick.png" alt="tick">
                                <% end_if %>
                            </td>
                    </tr>
                    <% end_loop %>
                </tbody>
            </table>
        </div>
        <a href="$Link/editaddress" class="button small-button">Add</a>
    </div>
    <div class="clear"></div>
    <div class="large-6 small-12 center columns no-pad-right account-section">

        <div class="large-12">
            <h2 class="text-center medium">RECENT ORDERS</h2>
            <% if Orders %>
            <table id="address-book">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>
                            <% _t( 'AccountPage.DATE', 'Date') %>
                        </th>
                        <th>
                            <% _t( 'AccountPage.TOTAL', 'Total') %>
                        </th>
                        <th>
                            <% _t( 'AccountPage.STATUS', 'Status') %>
                        </th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <% loop Orders %>
                    <tr>
                        <td>$ID</td>
                        <td>$OrderedOn.Format(j M y)</td>
                        <td>$TotalPrice.Nice</td>
                        <td>$Status ($PaymentStatus)</td>
                        <td>
                            <a href="$Link">
                                <% _t( 'AccountPage.VIEW_THIS_ORDER', 'View this order') %>
                            </a>
                        </td>
                    </tr>
                    <% end_loop %>
                </tbody>
            </table>
            <% else %>
            <div class="alert alert-info">
                <% _t( 'AccountPage.NO_ORDERS', 'You do not currently have any orders. In future you will be able to view your recent orders from here.') %>
            </div>
            <% end_if %>
        </div>
        <a href="/" class="button small-button">EDIT</a>
    </div>
</div>
