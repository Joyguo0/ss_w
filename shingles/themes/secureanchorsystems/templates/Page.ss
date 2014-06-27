<!doctype html>

<!--[if !IE]><!-->
<html>
<!--<![endif]-->
<!--[if IE 6 ]><html class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html class="ie ie8"><![endif]-->

<head>

<meta charset="utf-8">

<meta name="description" content="Secure Anchor Systems is a manufacturer and supplier of roof anchors and associated products to enable safe work at heights on all manner of buildings whether domestic dwellings, commercial or industrial buildings.">

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

<!-- Google Fonts -->

<!-- HTML5 Shiv -->
<!--[if lt IE 9]>
<script src="script/html5shiv.js"></script>
<![endif]-->

<!-- Print CSS -->
<link rel="stylesheet" href="$ThemeDir/css/print.css" type="text/css" media="print" />

<!-- Google Fonts -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<!-- Firefox Fix! -->


</head>
<body class="$ClassName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
	<% include Header %>
		
	<!-- Mobile Menu -->
	<div id="mobilemenu"></div>
	<div class="clear-mobilequery"></div>

	$Layout
		
	<% include Footer %>

</body>
</html>


