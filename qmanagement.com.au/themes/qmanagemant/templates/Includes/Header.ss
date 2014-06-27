<div class="header row">
    <div class="large-2 medium-6 small-9 columns">
        <a href="">
            <img src="$SiteConfig.Toplogo.url()" alt="">
        </a>
    </div>
    <div class="medium-6 small-3 hide-for-large-up columns">
        <a id="sidemenu" href="#sidr"><i class="fa fa-bars"></i></a>
    </div>
    <div class="large-10 show-for-large-up columns">
        <% loop $SearchForm %>
        <form $FormAttributes class="search">
            <div class="row collapse">
                <div class="small-10 columns">
                    <input name="Search" type="text" placeholder="Search...">
                </div>
                <div class="small-2 columns">
                    <a href="#" class="postfix go"><i class="fa fa-search"></i></a>
                </div>
            </div>
        </form>
        <% end_loop %>
        <% include Navigation %>
    </div>
</div>
<% if $useTitleBar %>
<div class="title-bar">
    <div class="swish"></div>
    <div class="row">
        <div class="large-12 columns">


            <h1>$Title</h1>
        </div>
    </div>
</div>
<% include Breadcrumbs %>
<% end_if %>
