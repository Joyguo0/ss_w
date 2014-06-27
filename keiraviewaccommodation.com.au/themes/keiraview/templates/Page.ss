<!doctype html>
<html lang="$ContentLocale">
<!--<![endif]-->
<!--[if IE 6 ]><html lang="$ContentLocale" class="ie ie6"><![endif]-->
<!--[if IE 7 ]><html lang="$ContentLocale" class="ie ie7"><![endif]-->
<!--[if IE 8 ]><html lang="$ContentLocale" class="ie ie8"><![endif]-->
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
$MetaTags(false)

<link rel="shortcut icon" href="favicon.ico">

<!-- Google Fonts -->
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,600,700' rel='stylesheet' type='text/css'>

<!-- HTML5 Shiv -->
<!--[if lt IE 9]>
<script src="themes/keiraview/plugins/html5shiv/html5shiv.js"></script>
<![endif]-->

<!-- One Percent Responsive Grid -->
<link rel="stylesheet" type="text/css" href="themes/keiraview/plugins/onepcssgrid/onepcssgrid.css">

<!-- Main Stylesheet -->
<% require themedCSS(style) %> 

<!-- Fontello Stylesheet -->
<link rel="stylesheet" href="themes/keiraview/fontello/css/fontello.css" media="all">
<!--[if lt IE 8]>
	<link rel="stylesheet" href="themes/keiraview/fontello/css/fontello-ie7.css" media="all">
<![endif]-->

<!-- jQuery -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> 

<!-- Easing -->
<script src="themes/keiraview/plugins/easing/jquery.easing-1.3.js"></script>

<!-- FlexSlider -->
<link rel="stylesheet" href="themes/keiraview/plugins/flexslider/flexslider.css" media="all">
<script src="themes/keiraview/plugins/flexslider/jquery.flexslider-min.js"></script>
<script>
$(document).ready(function() {
	var flexsliderDOM = $('.flexslider');
	if(flexsliderDOM.length){
		flexsliderDOM.flexslider({
			animation: "fade",
			controlsContainer: ".caption",
			controlNav: false,
			prevText: '<span></span>',
			nextText: '<span></span>',
			start: function(slider){
			  $('.flexslider').removeClass('loading');
			}
		   
		});
	}
});
</script>


<!-- ToolTip -->
<script type="text/javascript" src="themes/keiraview/plugins/qtip2/jquery.qtip.min.js"></script>
<link rel="stylesheet" href="themes/keiraview/plugins/qtip2/jquery.qtip.min.css" media="all">
<script type="text/javascript" src="themes/keiraview/plugins/qtip2/imagesloaded.min.js"></script>
<script>
// Create the tooltips only when document ready
$(document).ready(function() {
	 // MAKE SURE YOUR SELECTOR MATCHES SOMETHING IN YOUR HTML!!!
	 $('.hasTooltip').each(function() {
		 $(this).qtip({
			 content: {
				 text: $(this).next('div')
			 },
			 position: {
				my: 'bottom center',  // Position my top left...
				at: 'top center', // at the bottom right of...
				target: $(this) // my target
			},
			hide: {
				fixed: true
			},
			style: {
				classes: 'qtip-bootstrap',
				def: false
			}
		 });
	 });
	 
 });
</script>

<!-- Lightbox -->
<link rel="stylesheet" href="themes/keiraview/plugins/magnificpopup/magnificpopup.css" media="all">
<script type="text/javascript" src="themes/keiraview/plugins/magnificpopup/magnificpopup.js"></script>
<script>
$(document).ready(function() {
	$('.thumbnails').magnificPopup({
		delegate: 'a', // child items selector, by clicking on it popup will open
		type: 'image',
		gallery: { enabled: true }
	});
	$('.sidebar-images').magnificPopup({
		delegate: 'a', // child items selector, by clicking on it popup will open
		type: 'image',
		gallery: { enabled: true }
	});
	
});
</script>

<!--Mobile Menu -->
<link rel="stylesheet" href="themes/keiraview/bestmenu/mobile/meanmenu.css" media="all">
<script type="text/javascript" src="themes/keiraview/bestmenu/mobile/jquery.meanmenu.js"></script>
<script>
jQuery(document).ready(function () {
    jQuery('header nav').meanmenu({
		meanScreenWidth: "768",
		meanMenuContainer: '#mobilemenu'
	});
});
</script>


<!-- ZoomFlow -->
<link rel="stylesheet" href="themes/keiraview/plugins/zoomflow/zoomflow.css" media="all">
<script type="text/javascript" src="themes/keiraview/plugins/zoomflow/zoomflow.js"></script>
<script>
jQuery(document).ready(function($){
	jQuery("#slider").zoomflow({
		settings_slideshowTime: 				'5',
		settings_slideshow: 					'off',
		settings_slideshowDontChangeOnHover: 	'on',
		settings_skin: 							'skin-default',
		settings_responsive: 					'on',
		settings_mode: 							'normal',
		design_ratio: 							'3:2',
		design_maxwidth: 						'1400',
		design_padding: 						'10',
		design_enableShadows: 					'off'
	});
});
</script>
<!-- Tabs -->
<script src="$ThemeDir/plugins/easytabs/jquery.easytabs.js" type="text/javascript"></script>
<script>
$(document).ready(function() {
	$('#tab-container').easytabs();
});
</script>


</head>

<body class="$ClassName<% if not $Menu(2) %> no-sidebar<% end_if %>" <% if $i18nScriptDirection %>dir="$i18nScriptDirection"<% end_if %>>
<% include Header %>
<div class="main-area" role="main">
	<div class="onepcssgrid-1140">
		$Layout
	</div>
</div>
<% include Footer %>

</body>
</html>

