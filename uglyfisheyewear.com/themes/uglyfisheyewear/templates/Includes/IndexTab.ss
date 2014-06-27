<div class="large-8 small-12 columns tab-container" id="tab-container">
    <!-- Tab titles-->
    <ul class="etabs">
        <li class="tab center">
            <a href="#tab-best-sellers" class="bebas-mid white shrink-font">best sellers</a>
        </li>
        <li class="tab center">
            <a href="#tab-lifestyle" class="bebas-mid  white shrink-font">shop lifestyle</a>
        </li>
        <li class="tab center">
            <a href="#tab-ugly-guide" class="bebas-mid  white shrink-font">ugly guide</a>
        </li>
        <li class="tab center">
            <a href="#tab-ugly-story" class="bebas-mid  white shrink-font">ugly story</a>
        </li>
    </ul>
    
    <div id="tab-best-sellers" class="small-12">
        <% loop $LoadBestSellersProducts %>
            <% include ProductItem %>
        <% end_loop %>
        
        <a href="$LoadProductListingPage.Link" class="button red-button small-button float-right">View More &raquo;</a>
    </div>
    
    
    
    <div id="tab-lifestyle" class="small-12">
    
        <div class="large-4 small-6 column">
            <a href="/" id="get-wet"></a>
        </div>
        
    </div>
    
    <div id="tab-ugly-guide" class="small-12">
        <h2>CSS Styles for these tabs</h2>
        <p>  </p>
    </div>
    
    <div id="tab-ugly-story" class="small-12">
        <h2>The Ugly Story</h2>
        <p>  </p>
    </div>
</div>