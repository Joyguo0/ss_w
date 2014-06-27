<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">
    <h1 class="text-center">$Title</h1>

    <div class="large-6 small-12 columns center no-pad-right account-section">
        $Content
        <% if AddressForm %>$AddressForm
        <% else %>$Form
        <% end_if %>


    </div>

</div>
