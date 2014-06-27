
<div class="category-listing <% if $MultipleOf(3) || $isThird %>third<% end_if %>">
	<div class="category-image">
        <img src="$Photo.CroppedImage(300,225).URL" alt="$Title" title="$Title" />
        <div class="category-overlay">
            <a href="$Link" title="Read More &raquo;">Read More &raquo;</a>
        </div>
    </div>
	<div class="category-content">
    	<h3><a href="$Link" title="Name">$Title</a></h3>
    	<p>$Content.LimitCharacters(180)</p>
        <a href="$Link" class="readmore" title="#">Read More &raquo;</a>
    </div>
    <div class="clear"></div>
</div>