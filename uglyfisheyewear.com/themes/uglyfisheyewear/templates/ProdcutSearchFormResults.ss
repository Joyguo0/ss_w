<!DOCTYPE html>
<!--[if IE 8]>               <html class="no-js lt-ie9" lang="en" > <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->

<head>
    <% base_tag %>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Ugly Fish Eyewear</title>

    <!--[if IE 8]><link rel="stylesheet" href="$ThemeDir/css/ie8.css">
    <![endif]-->

    <!-- web fonts -->
</head>

<body>
    <% include Header %>
    <div class="column" id="body-content">



        <% include BannerNews %>

        <% include Breadcrumbs %>

        <div class="row">

            <div class="large-3 small-12 column no-pad-left" id="left-col">
                <% include ProductSidebar %>
            </div>


            <div class="large-9 small-12 columns no-pad-right white-content-area" id="right-col">

                <div class="content">

                    <% include Products %>

                </div>
            </div>

        </div>


    </div>
    <% include Footer %>

</body>

</html>
