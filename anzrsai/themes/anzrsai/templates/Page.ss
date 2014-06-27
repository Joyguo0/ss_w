<!DOCTYPE html>
<!--[if lt IE 7]> <html lang="$ContentLocale" class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>    <html lang="$ContentLocale" class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>    <html lang="$ContentLocale" class="no-js lt-ie9"> <![endif]-->
<!--[if IE 9]>    <html lang="$ContentLocale" class="no-js lt-ie10"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="$ContentLocale" class="no-js"> <!--<![endif]--> 
<!--[if IE 8]><html class="lt-ie9" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en"><![endif]-->
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
	  
	<!-- web fonts -->    
	<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,500,700' rel='stylesheet' type='text/css'>  
	<% require themedCSS('foundation') %>
	<% require themedCSS('style') %>
	<% require themedCSS('jquery.sidr.light') %>
	<% require themedCSS('rslides') %>	
		
	<!--[if lt IE 9]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.1.0/respond.min.js"></script>
	<![endif]-->     
	
	<!--[if lte IE 8]>
		<link rel="stylesheet" href="$ThemeDir/css/ie8.css">
	<![endif]--> 
		  
	<link rel="stylesheet" href="$ThemeDir/css/normalize.css">	  
	
	<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />
	<link rel="icon" href="$ThemeDir/images/favicon.ico" />
	<% if $ClassName == News %>
		<!-- SIDE NAV -->
		<script type="text/javascript" language="javascript" charset="utf-8" src="js/side-nav.js"></script>
		  
		<!-- sharethis -->  
		<script type="text/javascript">var switchTo5x=true;</script>
		<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
		<script type="text/javascript">stLight.options({publisher: "ur-f3c4a90-89c0-5419-1248-7fd269beeee", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>    
	<% end_if %>
	
	<% if $ClassName == BlogHolder %>
	   <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<% else_if $ClassName == BlogEntry %>   
	   <script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
	<% end_if %>
	
	 <!-- Moderniser -->
	<script src="$ThemeDir/javascript/vendor/custom.modernizr.js"></script>	
	
	<!-- GA code -->
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
    
      ga('create', 'UA-476031-39', 'anzrsai.org');
      ga('send', 'pageview');
    </script>
	
</head>
<body class="$ClassName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<div class="page-wrap">

	<% include Header %>
	$Layout
</div>
<% include Footer %>

</body>
</html>
