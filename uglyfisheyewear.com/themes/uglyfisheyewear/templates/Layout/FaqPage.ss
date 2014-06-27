
<div class="row">

	<!-- Content -->

	<div class="large-9 small-12 columns push-3 no-pad-right white-content-area" id="right-col">

			<% loop $Questions %>
      			 <div class="large-12 toggle">
                    <div class="toggle-trigger">
                        <h4 class="light">$Title</h4>
                    </div>
                    <div class="toggle-content column">
                        $Content
                    </div>
                </div> 
			     
			<% end_loop %>
	</div>
	<div class="large-3 small-12 column pull-9 no-pad-left" id="left-col">
		<% include SideBar %>
	</div>
</div>