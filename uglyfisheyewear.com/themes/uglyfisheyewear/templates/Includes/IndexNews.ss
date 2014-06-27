<div class="large-4 small-12 columns home-news-container">
    <% if $LatestNews %>
        <% loop $LatestNews %>
            <div class="home-news column">
                <h3><a class="bebas-mid white" href="$Link" title="$Title">$Title</a></h3>
                <a class="large-6 column no-pad-left" href="$Link" title="$Title"><% if $Image %>$Image.CroppedImage(161,95)<% end_if %></a>
                <p class="large-6 column small no-pad small light">
                    $Content.LimitCharacters(70)<a  title="$Title" href="$Link" class="button small-button news-read-more">READ MORE &raquo;</a>
                </p>
            </div>
        <% end_loop %>
    <% end_if %>

    <div class="home-news column twitter-feed">
        <h3 class="bebas-mid"><a class="white" href="/">@UGLYFISHSUNNIES</a><span class="float-right light">FEB 11</span></h3>
        <p class="large-12 column small no-pad small light">
            Check out our Exhibitor Spotlight on <a href="/">@SIAevents Darwin</a>. Just over a month till we head 2 <a href="/">@DarwinConventio</a>. <a href="/">http://www.safetyinaction.net.au/darwin/visitor/event-industry-news/exhibitor-spotlight</a> … <a href="/">#SIADarwin</a>
        </p>
    </div>
</div>