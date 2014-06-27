;jQuery(function($) {
	
	$('#Form_ItemEditForm_RedirectionType_Internal').livequery(function(){
		if($(this).is(':checked')){
			//hide external input
			$('#ExternalURL').hide();
		}
	});
	
	$('#Form_ItemEditForm_RedirectionType_External').livequery(function(){
		if($(this).is(':checked')){
			//hide external input
			$('#LinkToID').hide();
		}
	})
	
	$('#Form_ItemEditForm_RedirectionType_Internal').livequery('change', function() {
		$('#ExternalURL').hide();
		$('#LinkToID').show();
	});
	
	$('#Form_ItemEditForm_RedirectionType_External').livequery('change', function() {
		$('#ExternalURL').show();
		$('#LinkToID').hide();
	});
	
}); 