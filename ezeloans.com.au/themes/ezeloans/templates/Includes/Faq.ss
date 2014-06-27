<!-- Collapsibles -->
<% loop $Questions %>
      
      <div class="collapsible-area">
            <!-- Collapsible -->
            <div class="collapsible" id="nav-section1">$Title<span></span></div>
            <div class="container">
                <p>$Content</p>
            </div>
        </div>
<% end_loop %>

<script>
$(document).ready(function() {
    //collapsible management
    $('.collapsible').collapsible({
    });
});
</script>