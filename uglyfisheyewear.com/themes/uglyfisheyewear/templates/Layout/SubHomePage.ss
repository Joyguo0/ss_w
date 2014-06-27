<% include BannerNews %>
<% include Breadcrumbs %>
<div class="row sub-home">
<!-- LINK AND IMAGE BANNER -->
<% loop $Obaseone.limit(2) %>
    <div class="large-6 column no-pad-left">            
        <div class="sub-banner with-image column collapse">
            <div class="inner-border">                    
                <div class="large-4 small-6 column banner-content">
                    <h4 class="red bebas-mid"><a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>">$Title</a></h4>
                    <p class="light uppercase cond bbb">$Content</p>
                    <a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>" class="button mid-button white-button">VIEW NOW &raquo;</a>
                </div>
                <div class="large-7 small-6 column">
                    <div class="banner-image">
                        <img class="relative" src="$Oimage.URL()">
                        <img class="banner-image-border small-hide" src="$ThemeDir/images/banner-jag-frame.png">
                    </div>
                </div>
            </div>    
        </div>
	</div>
<% end_loop %>
                
<div class="clear"></div>

<% loop $Subbanners.limit(3) %>
    <div class="large-4 column no-pad-left">            
        <!-- centered text and link BANNER -->
        <div class="sub-banner column">
            <div class="inner-border">
                <div class="large-12 column">
                    <h4 class="bebas-mid center"><a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>" class="white">$Title</a></h4>
                </div> 
                <div class="clear"></div>   
                <a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>" class="button mid-button white-button center">VIEW NOW &raquo;</a>
            </div>                            
        </div>
    </div>
<% end_loop %>
</div>