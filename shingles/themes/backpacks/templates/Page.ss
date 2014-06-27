<!doctype html>

<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!--[if IE 6 ]><html class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8"><![endif]-->

<head>

<meta charset="utf-8">

<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">

<!-- Viewport Set -->
<meta http-equiv="cleartype" content="on">
<meta name="HandheldFriendly" content="True">
<meta name="MobileOptimized" content="320">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)

<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico">

<!-- HTML5 Shiv -->
<!--[if lt IE 9]>
<script src="script/html5shiv.js"></script>
<![endif]-->

</head>
<body class="$ClassName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
	<% include Header %>
	
	<!-- Mobile Menu -->
	<div id="mobilemenu"></div>
	<div class="clear-mobilequery"></div>

	$Layout
		
	<% include Footer %>
	
	<script src="themes/backpacks/javascript/localscroll/jquery.scrollTo-1.4.3.1-min.js"></script>
	<script src="themes/backpacks/javascript/localscroll/jquery.localscroll-min.js"></script>
	<script>
	$(document).ready(function() {
		$('#box-links').localScroll({
	       target:'body'
	    });
	});
	</script>
	
</body>
</html>

