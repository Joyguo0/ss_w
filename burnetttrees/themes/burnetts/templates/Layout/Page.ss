<div class="row">
    <div class="large-12 columns">
        <h1 class="page-title">$Title</h1>
        <% include BreadCrumbs %>
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
            <div class="article large-8 columns">
                $Content
                $Form
            </div>
            
            <div class="images large-4 columns">
                
                <% if $LoadPageBanners %>
		        	<% loop $LoadPageBanners %>
		        		
		        		<img alt="$Title" title="$Title" src="$Image.URL">
		        		
            		<% end_loop %>
				<% end_if %>
				
            </div>
        </div>
    </div>
</div>