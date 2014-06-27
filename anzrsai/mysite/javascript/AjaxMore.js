$(document).ready(function(){
	

$('#showmore').click(function(){
	
	var start_number = $(this).attr('data-start');
	//var categoryid = $(this).attr('data-categoryid');
	var ajaxlink = $(this).attr('data-link');
	var showmoreDOM = $(this);
	
	$.ajax({
		   url: ajaxlink + "?start=" + start_number,
		   timeout: 5000,
		   type: "GET",
		   dataType: "json",
		   success: function(response) {
			   if(response.html){
				   
				   $('.ajaxcallback').before(response.html);
				   if(!(parseInt(response.start) + parseInt(response.length) < parseInt(response.sum))){
					   showmoreDOM.hide();
				   }else{
					   start_number = parseInt(response.start) + parseInt(response.length);
					   showmoreDOM.attr('data-start', start_number);
				   }
				   
				   
			   }
		   },
		   error: function(xhr) {
		    console.log(xhr);
		   }
	});
	
	
});


});