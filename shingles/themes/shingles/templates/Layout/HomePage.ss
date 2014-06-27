<div class="home-main">
    <div class="onepcssgrid-1140">
		<% include Slideshow %>



		$Content
		
		<div class="col3 last">
			<% include ShingleType %>
		</div>
		<div class="clear"></div>

		<div class="col12">
			<h3 class="carousel-header">Our Products</h3>
		</div>
		<div class="col12">
			<div class="other-works-container">
				<div class="carousel">
				
					<% loop $GetShingleHolderPage(9) %>
						<a href="$Link" title="Shingle Title"  >	
							<div class="slide">
								<img src="$Photo.setSize(300,225).URL" alt="$Title" title="$Title" />
								<div class="slidetext">
									<h5>$Title</h5>
									<p>$Content.LimitCharacters(100)</p>
								</div>
							</div>
						</a>
					<% end_loop%>
					
				</div>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>