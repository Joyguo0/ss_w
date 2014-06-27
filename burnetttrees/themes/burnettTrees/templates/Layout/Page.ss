
<div class="row">
        <div class="large-12 columns">
            <h1>$Title</h1>
            <% include BreadCrumbs %>
            <hr />
        </div>
</div>
<div class="row">
        <div class="large-3 columns show-for-large-up">
            <!--
            -->
            <% include SlideBarshow %>
        </div>
        <div class="large-9 columns">
            <% if $Introductory %>
	            <div class="article-tag row columns">
	                $Introductory
	            </div>
            <% end_if %>
            <div class="row">
                $Content
                
                $Form
            </div>
        </div>
</div>