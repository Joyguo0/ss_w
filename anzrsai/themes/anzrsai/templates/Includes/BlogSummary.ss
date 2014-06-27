<div class="row">   
	<div class="news-bit">
	    <a id="news-head" href="$Link">$Title<span id="news-date">$Date.Long</span></a>
		<div class="large-3 columns start">
	        <!-- <a href="/"><img src="images/basic-img.jpg"></a>-->
	        <% if Image %>
				<a href="$Link"> <img src="$Image.CroppedImage(280,187).URL" alt="$Title" title="$Title" style="display:inline"/></a>
			<% end_if %>
		</div>
		<div class="large-9 columns last">
				
			<p> $Summary.LimitCharacters(270) <a href="$Link"> Read More &raquo;</a></p>
		
	    </div>
	 </div> 
 </div>
