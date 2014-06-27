<!DOCTYPE html>

<html lang="$ContentLocale">

<!--[if !IE]><!-->
<html lang="$ContentLocale">
<!--<![endif]-->
<!--[if IE 6 ]><html lang="$ContentLocale" class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html lang="$ContentLocale" class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="$ContentLocale" class="ie ie8"><![endif]-->
<!--[if IEMobile 7 ]> <html dir="ltr" lang="$ContentLocale"class="ie"> <![endif]-->
<!--[if (gte IE 9)|(gt IEMobile 7)|!(IEMobile)|!(IE)]><!--><html dir="ltr" lang="$ContentLocale" class="ie ie9"><!--<![endif]-->
<head>
	<% base_tag %>
	
	<meta charset="utf-8">

	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 

	<!-- Viewport Set -->
	<meta http-equiv="cleartype" content="on">
	<meta name="HandheldFriendly" content="True">
	<meta name="MobileOptimized" content="320">
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

	<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />
	
	<script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-50346316-1', 'ezeloans.com.au');
      ga('send', 'pageview');
    </script>
</head>

<body>
<div id="skrollr-body">
    <!-- Mobile Menu -->
    <div id="mobilemenu"></div>
    <% if getHeaderName()==HomePage %>
    	<!-- Home Banner -->
    	<div class="home-banner" style='background-image: url(<% if $LoadHomeBannerImage %>$LoadHomeBannerImage.SetWidth(1920).URL<% else %>/themes/ezeloans/images/mountain.jpg<% end_if %>);'>
    		
    		<% include Header %>
    	    
    	    <div class="clear"></div>
    		
    	    <!-- Centered banner stuff -->
    		<div class="onepcssgrid-1140">
    	    	<div class="col3"><div class="space"></div></div>
    	        <div class="col6">
    	        	<div class="text-bit">
    	                <h3>$BannerTitle</h3>
    	                <p>$BannerContent</p>
    	                <div id="box-links">
    	                	 <a class="button" title="$SiteConfig.ApplyForPreapproval.Title"   href="<% if $SiteConfig.ApplyForPreapproval %>$SiteConfig.ApplyForPreapproval.getLinkURL<% end_if %>">$SiteConfig.ApplyForPreapproval.Title</a>
    	                </div>
    	            </div>
    	        </div>
    	        <div class="col3 last"><div class="space"></div></div>
    	        <div class="clear"></div>
    	    </div>
    	    
    	</div>
    
    <% else_if getHeaderName()==LandingPage  %>
        <!-- Home Banner -->
        <div class="landing-banner" data-0="background-position: center -100px;" data-1000="background-position:center 50px;" style='background: url($BannerImage.url())'>
            <!-- Centered banner stuff -->
        	<div class="onepcssgrid-1140">
            	<div class="col2"><div class="space"></div></div>
                <div class="col8">
                	<div class="text-bit"  data-0="opacity: 1;" data-500="opacity: 0;">
                    	<!-- Logo -->
                        <a class="logo" href="/">
                            $SiteConfig.Toplogo
                        </a>
                        <h3>$BannerTitle</h3>
                        <p>$BannerContent</p>
                        <div id="box-links">
                            <a class="button" title="$SiteConfig.ApplyForPreapproval.Title"   href="<% if $SiteConfig.ApplyForPreapproval %>$SiteConfig.ApplyForPreapproval.getLinkURL<% end_if %>">$SiteConfig.ApplyForPreapproval.Title</a>
                        </div>
                    </div>
                </div>
                <div class="col2 last"><div class="space"></div></div>
                <div class="clear"></div>
            </div>		
        </div>
    <% else %>
    	<% include Header %>
    <% end_if %>
    
    $Layout
    
    <% include Footer %>
</div>
</body>
</html>
