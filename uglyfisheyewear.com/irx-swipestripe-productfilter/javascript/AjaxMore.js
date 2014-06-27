$(document).ready(function(){
	
	$('#showmore').click(function(e){
		
		e.preventDefault();
		
		var ButtonLink = $(this).attr('href');
		var showmoreDOM = $(this);
		
		$.ajax({
			   url: ButtonLink ,
			   timeout: 5000,
			   type: "GET",
			   dataType: "json",
			   success: function(response) {
				   //add products
				   if(response.product_html){
					   $('.ajaxcallback').before(response.product_html);
				   }
				   
				   //update nextlink
				   if(response.nextlink){
						showmoreDOM.attr('href', response.nextlink);
				   }else{
					   showmoreDOM.hide();
				   }
			   },
			   error: function(xhr) {
			    console.log(xhr);
			   }
		});
	});
	
});