<!doctype html>
<html class="no-js" lang="en">

<head>
    <% base_tag %>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <script type="text/javascript" src="http://use.typekit.net/emh5src.js"></script>
    <script type="text/javascript">
    try {
        Typekit.load();
    } catch (e) {}
    </script>
    <title>
        <% if $MetaTitle %>$MetaTitle
        <% else %>$Title
        <% end_if %>&raquo; $SiteConfig.Title</title>



</head>

<body>

    <% include Header %>$Layout

    <% include Footer %>

</body>

</html>
