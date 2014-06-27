<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">

    <div class="large-9 small-12 columns push-3 no-pad-right white-content-area news" id="right-col">
        <h1>ugly news</h1>
        <div class="large-10 column" id="news-refine">
            <h2>REFINE BY &#45;</h2>
            <p>$paramID
                <a href="$Link" <% if not $CheckActiveCategoryID %>class="active"
                    <% end_if%>>ALL</a>
                <% loop NewsCategorys %>&#124;
                <a href="<% with $CurrentPage %>$Link<% end_with %>/CategorysSeach/$ID" <% if $paramID==$ID %> class="active"<% end_if %>>$Title</a>
                <% end_loop %>
            </p>
        </div>
        <div class="large-2 small-12 column">
            <a href="$CurrentPage.URLSegment/archive" class="button small-button float-right">ARCHIVE &raquo;</a>
        </div>

        <div class="clear"></div>
        <% include NewsList %>

    </div>
    <div class="large-3 small-12 column pull-9 no-pad-left" id="left-col">
        <% include SideBar %>
    </div>
</div>
