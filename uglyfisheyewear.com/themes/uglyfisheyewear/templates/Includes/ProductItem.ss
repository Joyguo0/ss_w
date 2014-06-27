<div class="product-list large-4 small-6 columns $LabelImageClass">
    <a class="product-image" href="$Link">
        $ProductThumbnail.SetSize(224,168)
        
        <% if $IsSale %><img class="sale-badge" src="$ThemeDir/images/sale-badge.png" alt="Sale"><% end_if %>
        <% if $IsNewPro %><img class="new-badge" src="$ThemeDir/images/new-badge.png" alt="New Product"><% end_if %>
    </a>

    <a href="$Link">$Title.XML</a>

    <% if $IsSale %>
    <span class="price">$Price.Nice</span>
    <span class="sale-price">$getUglyPrice()</span>
    <% else %>
    <span class="price">$Price.Nice</span>

    <% end_if %>
</div>
