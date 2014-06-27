<% include BreadCrumbs %>
<div class="multistep">
    
    <div class="onepcssgrid-1140">
    	<div class="col12">
    
            <div id="form-steps">
                <a <% if $getSetpNum=1 %> class="current" <% end_if %> href="#">Information</a>
                <a <% if $getSetpNum=2 %> class="current" <% end_if %> href="#">Payment</a>
                <a <% if $getSetpNum=3 %> class="current" <% else %> class="last" <% end_if %>  href="#">Confirmation</a>
                <div class="clear"></div>
            </div>
            
            <div class="clear"></div>
            
        </div>
    </div>
    
</div>

<% if $Content %>
	$Content
<% else %>
	<div class="payment-form">
	    <div class="onepcssgrid-1140">
	    
	    	<div class="col3"><div style="height:1px;width:1px;"></div></div><!-- Spacer -->
	    
	    	<!-- Contact Form -->
	        <div class="col6">
	        	
	            <!-- Form/Fields -->
	        	<div class="contact">
	               	$PaymentMultiForm
	                
	            </div>
	        </div>
	        
	        <div class="col3 last"><div style="height:1px;width:1px;"></div></div><!-- Spacer -->
	        
	        <div class="clear"></div>
	    
	    </div>
	</div>
<% end_if %>
