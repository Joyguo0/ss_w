<!DOCTYPE html>
<!--[if IE 9]><html class="lt-ie10" lang="en" > <![endif]-->
<html class="no-js" lang="$ContentLocale" data-useragent="Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.2; Trident/6.0)">
<head>
	<% base_tag %>
	<title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %> &raquo; $SiteConfig.Title</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	$MetaTags(false)
	<!--[if lt IE 9]>
	<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700|Oswald' rel='stylesheet' type='text/css'>
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet" />
    <link href="themes/burnetts/slick/slick.css" rel="stylesheet" />
    <script src="themes/burnetts/javascript/vendor/modernizr.js"></script>
	
	<% require themedCSS('foundation') %>
	<% require themedCSS('foundation.min') %>
	<% require themedCSS('normalize') %>
	<% require themedCSS('style') %>

    <% if $SiteConfig.ThemeRed %>
        <% require themedCSS('style-red') %>
    <% end_if %>

	<link rel="shortcut icon" href="$ThemeDir/images/favicon.ico" />
</head>
<body  class="$ClassName<% if not $Menu(2) %> no-sidebar<% end_if %>"  <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<% include Header %>

		$Layout

<% include Footer %>

<% require javascript('framework/thirdparty/jquery/jquery.js') %>
<%-- Please move: Theme javascript (below) should be moved to mysite/code/page.php  --%>
<script type="text/javascript" src="{$ThemeDir}/javascript/script.js"></script>

</body>
</html>
