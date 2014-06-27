<% if Stores %>

    <% loop Stores %>
    
        <% include StoreItem %>
    
    <% end_loop %>
    
<% else %>

    <p>No Search Results! Please search again or reset map.</p>

<% end_if %>
