<% if $GalleryImages %>
    <% loop $GalleryImages %>
    
        <div class="column-images <% if MultipleOf(2) %>last<% end_if %>">
            $Image.CroppedImage(424, 187)
        </div>
        
        <% if MultipleOf(2) %>
            <div class="clear"></div>
        <% end_if %>
        
    <% end_loop %>
<% end_if %>