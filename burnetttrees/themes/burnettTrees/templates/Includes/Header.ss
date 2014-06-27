<!-- 
Header
-->
<header>
        <div class="row head">
            <div class="large-3 columns">
              	<!-- <a href="/"><img src="themes/burnetts/images/logo.jpg"></a>-->
              	<a href="/">
              		$SiteConfig.Logo
              	</a>
            </div>
            <div class="large-9 columns">
                <div class="row show-for-large-up">
                    <div class="right">                
                        <div class="search-wrapper row collapse">     

                       	<% with SearchForm %>
					        <form id="head-search" $FormAttributes>
					           	<div class="medium-10 columns">
	                              <input class="search" type="text" placeholder="Search...">
	                            </div>
	                            <div class="medium-2 columns" style="padding-left: 0; padding-right: 0;">
	                              <a href="#" class="button search-btn postfix"><i class="fa fa-search"></i></a>
	                            </div>
					        </form>
						<% end_with %>
                        </div>
                        <div class="social-icons">
	                        <% if $SiteConfig.HeaderLinks %>
									<% loop $SiteConfig.HeaderLinks %>
									    <a href="$redirectionLink" class="button radius social-btn" $TargetAttr><i class="fa fa-{$LinkClass}"></i></a>
									<% end_loop %>
							<% end_if %>
							
                           
                        </div>                
                    </div>
                </div>
                <div class="row">
                    <div class="contact-details">
                        <i class="fa fa-phone"></i> $SiteConfig.Tel<i class="fa fa-map-marker"></i> $SiteConfig.Address <i class="fa fa-clock-o"></i> $SiteConfig.WorkTime
                    </div>     
                </div>
            </div>
        </div>
        <% include Navigation %>
    </header>  