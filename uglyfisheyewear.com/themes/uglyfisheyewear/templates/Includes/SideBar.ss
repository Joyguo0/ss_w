
<% if $Menu(2) && $ClassName != Store && $ClassName != OnlineStore && $ClassName != Distributor %>
	
	<% with $Level(1) %>
		<ul  id="menu">
			<% include SidebarMenu %>
		</ul>
	<% end_with %>

<% end_if %>


<% if LoadPageBanners %>
   <% loop $LoadPageBanners.limit(2) %> 
        <% if $Image.exists() %>
        <!-- LINK AND IMAGE BANNER -->
        <div class="sub-banner column collapse">
            <div class="large-6 small-6 column banner-content">
                <h4 class="red bebas-mid"><a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>">$Title</a></h4>
                <a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>" class="button mid-button white-button">VIEW MORE &raquo;</a>
            </div>
            <div class="large-6 small-6 column">
                <div class="banner-image">
                    <img class="relative" src="$Image.URL()">
                    <img class="banner-image-border small-hide" src="$ThemeDir/images/banner-jag-frame.png">
                </div>
            </div>
        </div>
        <% else %>
            <!-- centered text and link BANNER -->
            <div class="sub-banner column">
                <div class="inner-border">
                    <div class="large-12 column">
                        <h4 class="bebas-mid center"><a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>" class="white">$Title</a></h4>
                    </div> 
                    <div class="clear"></div>   
                    <a href="<% if $Olink %>$Olink.getLinkURL<% end_if %>" class="button mid-button white-button center">VIEW MORE &raquo;</a>
                </div>                            
            </div>
        <% end_if %>            
    <% end_loop %>
<% end_if %>




    <!-- centered text and link BANNER -->

<div class="sub-banner column" id="find-store-banner">
    <div class="inner-border">
        <div class="large-12 column">
            <h4 class="bebas-mid center"><a href="/" class="white">FIND A STORE</a></h4>
            <p class="small light text-center">Search for your state, suburb, postcode or enter keywords to find your nearest store.</p>
        </div>    
        <div class="large-12 column">                            
            <div class="search">
                <input type="text" id="find-store-banner-input" class="search-box" placeholder="">
                <a class="go" href="#" title="Click to search for this phrase"><img src="$ThemeDir/images/search-icon.png"></a>
            </div>
        </div>    
    </div>                            
</div>