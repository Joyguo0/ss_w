<% include BannerNews %>
<% include Breadcrumbs %>

<div class="row">

	<!-- Content -->

	<div class="row">
		<div class="large-9 column no-pad-left">
			<h1>CHECKOUT</h1> @@ ALL @@ 
			<% if $getStep.RecordClassName == 'CheckoutFormStep1' %>
				<a href="#">1</a>
			<% else_if $getStep.RecordClassName == 'CheckoutFormStep2' %>
				<a href="#">2</a>
            <% end_if %>
			<ol class="opc" id="checkout-steps">
				
			
				<div class="large-12 column toggle active">
	                <li class="section allow toggle-trigger">
	                    <div class="step-title">
	                        <h2>1/ Checkout Method</h2>
	                    </div>
	               	</li>     
	                <div id="checkout-step-login" class="toggle-content column" >
	                	<div class="large-12 column no-pad">  
	                    	$CheckoutMultiForm
	                    </div> 
	                </div>
	            </div>
	            
	            <div class="large-12 column toggle">
	                <li class="toggle-trigger">
	                    <div class="step-title">
	                        <h2>2/ Your Details</h2>
	                    </div>
	               	</li>     
	                <div id="checkout-step-details" class="toggle-content column" style="display: block;">
	                	<div class="large-12 inner column inline uppercase no-pad-right">  
	                    	$CheckoutMultiForm
	                    </div> 
	                </div>
	            </div>
	            
	            <div class="large-12 column toggle ">
	                <li class="section allow toggle-trigger">
	                    <div class="step-title">
	                        <h2>3/ Shipping</h2>
	                    </div>
	               	</li>     
	                <div id="ccheckout-step-shipping" class="toggle-content column" style="display: none;">
	                	<div class="large-12 inner column inline uppercase no-pad-right">  
	                    	$CheckoutMultiForm
	                    </div> 
	                </div>
	            </div>
	            
	            <div class="large-12 column toggle">
	                <li class="section allow toggle-trigger">
	                    <div class="step-title">
	                        <h2>4/ Payment Information</h2>
	                    </div>
	               	</li>     
	                <div id="checkout-step-payment" class="toggle-content column" style="display: none;">
	                	<div class="large-12 inner column inline uppercase no-pad-right">  
	                    	$CheckoutMultiForm
	                    </div> 
	                </div>
	            </div>
	            
	            <div class="large-12 column toggle">
	                <li class="section allow toggle-trigger">
	                    <div class="step-title">
	                        <h2>5/ Order Review</h2>
	                    </div>
	               	</li>     
	                <div id="checkout-step-review" class="toggle-content column" style="display: none;">
	                	<div class="large-12 column">  
	                    	$CheckoutMultiForm
	                    </div> 
	                </div>
	            </div>
			</ol>
			 <!-- checkout step 1 -->
			<!--         
            <ol class="opc" id="checkout-steps">
            	
            	<div class="large-12 column toggle active">
                    <li class="section allow toggle-trigger">
                        <div class="step-title">
                            <h2>1/ Checkout Method</h2>
                        </div>
                   	</li>     
                    <div id="checkout-step-login" class="toggle-content column" style="display: block;">
                        <div class="large-12 column no-pad">  
                        	<div class="large-6 inner column inline uppercase no-pad-left">
                            	<h4>ALREADY HAVE AN ACCOUNT?</h4>	
                                <div class="large-3 small-4 column">
                                    <label for="email" >EMAIL</label>
                                </div>
                                <div class="large-9 small-8 column">
                                    <input type="text" name="email" id="email" tab-index="0">
                                </div> 
                                <div class="large-3 small-4 column">
                            		<label for="password" >PASSWORD</label>
                                </div>
                                <div class="large-9 small-8 column">
                                	<input type="text" name="password" id="password" tab-index="0">
                                </div>    
                                <a href="/" class="small text-right column">I forgot my password</a>
                                <input type="submit" value="sign in & continue" class="button">
                            </div>    
                        	<div class="large-6 inner column inline uppercase no-pad-right">
                            	<h4>NEW CUSTOMER</h4>
                                <p class="cond">An account is not required to shop with us. You can check out as a guest or you can register to save your details for your next purchase.</p>
                                <div class="large-7 small-7 column">
                                	<input type="radio" id="as-guest" name="checkout-as">
                                    <label class="inline" for="as-guest">CHECKOUT AS GUEST</label>
                                </div>
                                <div class="large-5 small-5 column">
                                	<input type="radio" id="register" name="checkout-as">
                                    <label class="inline" for="register">register</label>
                                </div>
                                <input type="submit" value="continue" class="button">
                            </div>
                        </div>                                 
                    </div>
                </div>
            	2
            	<div class="large-12 column toggle">                            
                    <li class="toggle-trigger">
                        <div class="step-title">
                            <h2>2/ Your Details</h2>
                        </div>
                   </li>     
                    <div id="checkout-step-details" class="toggle-content column">
                        	<div class="large-12 inner column inline uppercase no-pad-right">
                            	<div class="large-6 column">
                                    <label for="first-name" >* FIRST NAME</label>
                                    <input type="text" name="first-name" id="first-name" tab-index="0">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="last-name" >* last NAME</label>
                                    <input type="text" name="last-name" id="last-name" tab-index="1">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="company" >Company</label>
                                    <input type="text" name="company" id="company" tab-index="2">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="email" >* email</label>
                                    <input type="text" name="email" id="email" tab-index="3">                                        	
                                </div>                                        
                            	<div class="large-12 column">
                                    <label for="address" >* Address</label>
                                    <input type="text" name="address" id="address" tab-index="4">  
                                    <input type="text" name="address" id="address" tab-index="5"> 
                                </div>
                            	<div class="large-6 column">
                                    <label for="city" >* City</label>
                                    <input type="text" name="city" id="city" tab-index="6">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="state" >* State/ Province</label>
                                    <input type="text" name="state" id="state" tab-index="7">                                        	
                                </div>  
                            	<div class="large-6 column">
                                    <label for="post-code" >* Zip/ Postal Code</label>
                                    <input type="text" name="post-code" id="post-code" tab-index="8">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="country" >* Country</label>
                                    <select name="country" id="country" tab-index="9">
                                    	<option value="">Select a Country...</option>                                            
                                    	<option value="Australia">Australia</option>
                                    	<option value="Australia">Australia</option>
                                    	<option value="Country">Country</option>
                                    </select>                                        	
                                </div> 
                                <div class="clear"></div>
                            	<div class="large-6 column">
                                    <label for="telephone" >* Telephone</label>
                                    <input type="text" name="telephone" id="telephone" tab-index="10">                                        	
                                </div>  
                            	<div class="large-6 column">
                                    <label for="fax" >Fax</label>
                                    <input type="text" name="fax" id="fax" tab-index="11">                                        	
                                </div> 
                            	<div class="large-6 column">
                                    <label for="create-password" >Create a Password</label>
                                    <input type="text" name="create-password" id="create-password" tab-index="10">                                        	
                                </div>  
                            	<div class="large-6 column">
                                    <label for="re-enter-password" >Re-Enter your password</label>
                                    <input type="text" name="re-enter-password" id="re-enter-password" tab-index="11">                                        	
                                </div>                                           
                                <div class="large-6 push-6 column">
                                	<p class="small red float-right text-right">* Required Field</p>
                                </div>                                              
                                <div class="large-6 pull-6 column">
                                	<div class="large-12 column">
                                        <input type="radio" id="this-address" name="ship-to" tab-index="12">
                                        <label class="inline" for="this-address">Ship to this Address</label>
                                	</div>
                                    <div class="large-12 column">
                                		<input type="radio" id="different-address" name="ship-to" tab-index="13">
                                    	<label class="inline" for="different-address">Ship to different Address</label>
                                    </div>   
                                </div>                                     
                                <input type="submit" value="continue" class="button">  	
                          </div>
                    </div>    
                </div>   
            	3
            	<div class="large-12 column toggle">                            
                    <li class="toggle-trigger">
                        <div class="step-title">
                            <h2>3/ Shipping</h2>
                        </div>
                   </li>     
                    <div id="checkout-step-shipping" class="toggle-content column">
                        	<div class="large-12 inner column inline uppercase no-pad-right">
                                <div class="large-12 column">
                                	<div class="shipping-box column">
                                        <input type="radio" id="details-add" name="details-add">
                                        <label class="inline" for="details-add">Use Address from your Details</label>
                                    </div>    
                                </div>                                       
                            	<div class="large-6 column">
                                    <label for="first-name" >* FIRST NAME</label>
                                    <input type="text" name="first-name" id="first-name" tab-index="0">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="last-name" >* last NAME</label>
                                    <input type="text" name="last-name" id="last-name" tab-index="1">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="company" >Company</label>
                                    <input type="text" name="company" id="company" tab-index="2">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="email" >* email</label>
                                    <input type="text" name="email" id="email" tab-index="3">                                        	
                                </div>                                        
                            	<div class="large-12 column">
                                    <label for="address" >* Address</label>
                                    <input type="text" name="address" id="address" tab-index="4">  
                                    <input type="text" name="address" id="address" tab-index="5"> 
                                </div>
                            	<div class="large-6 column">
                                    <label for="city" >* City</label>
                                    <input type="text" name="city" id="city" tab-index="6">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="state" >* State/ Province</label>
                                    <input type="text" name="state" id="state" tab-index="7">                                        	
                                </div>  
                            	<div class="large-6 column">
                                    <label for="post-code" >* Zip/ Postal Code</label>
                                    <input type="text" name="post-code" id="post-code" tab-index="8">                                        	
                                </div>
                            	<div class="large-6 column">
                                    <label for="country" >* Country</label>
                                    <select name="country" id="country" tab-index="9">
                                    	<option value="">Select a Country...</option>                                            
                                    	<option value="Australia">Australia</option>
                                    	<option value="Australia">Australia</option>
                                    	<option value="Country">Country</option>
                                    </select>                                        	
                                </div> 
                                <div class="clear"></div>
                            	<div class="large-6 column">
                                    <label for="telephone" >* Telephone</label>
                                    <input type="text" name="telephone" id="telephone" tab-index="10">                                        	
                                </div>  
                            	<div class="large-6 column">
                                    <label for="fax" >Fax</label>
                                    <input type="text" name="fax" id="fax" tab-index="11">                                        	
                                </div> 
                                <div class="large-12 column">
                                	<p class="small red float-right text-right">* Required Field</p>
                                </div>                                              
                                <div class="large-12 column">
									<div class="shipping-box column">                                        
                                        <div class="large-3 column">
                                            <input type="radio" id="standard" name="standard">
                                            <label class="inline" for="standard">STANDARD POST</label>
                                        </div>   
                                        <div class="large-6 column">
                                            <p class="text-center bbb">Expected Delivery Time 3-5 business days</p>
                                        </div>   
                                        <div class="large-3 column">
                                            <p class="text-right big">FREE</p>
                                        </div>   
                                    </div>    
                                    <div class="large-12 column shipping-box">
                                        <div class="large-3 column">
                                            <input type="radio" id="express" name="standard">
                                            <label class="inline" for="express">EXPRESS POST</label>
                                        </div>   
                                        <div class="large-6 column">
                                            <p class="text-center bbb">Expected Delivery Time 1-2 business days</p>
                                        </div>   
                                        <div class="large-3 column">
                                            <p class="text-right big">$6.95</p>
                                        </div>   
                                    </div>         
                                </div>                                                                     
                                <input type="submit" value="continue" class="button">  	
                          </div>
                    </div>    
                </div>  
            	4
            	<div class="large-12 column toggle">                            
                    <li class="toggle-trigger">
                        <div class="step-title">
                            <h2>4/ Payment Information</h2>
                        </div>
                   </li>     
                    <div id="checkout-step-payment" class="toggle-content column">
                        	<div class="large-12 inner column inline uppercase no-pad-right">
                                <div class="large-12 column">
                                	<div class="shipping-box column">
                                        <input type="radio" id="cc-payment" name="payment-method" checked>
                                        <label class="inline" for="cc-payment">Credit Card Payment</label>
                                                          
                                        <div class="large-12 column">
                                            <label for="card-name" >* Name on Card</label>
                                            <input type="text" name="card-name" id="card-name">  
                                        </div>
                                        <div class="large-6 column">
                                            <label for="card-type" >* Credit Card Type</label>
                                            <select name="card-type" id="card-type">
                                                <option >Select a Card Type...</option>
                                                <option value="Mastercard">Mastercard</option>    
                                                <option value="Visa">Visa</option>
                                            </select>                                           	
                                        </div>
                                        <div class="large-12 column">
                                            <label for="card-number" >* Credit Card NUmber</label>
                                            <input type="text" name="card-number" id="card-number">  
                                        </div>                                       
                                        <div class="large-6 column">
                                            <label for="state" >* State/ Province</label>
                                            <input type="text" name="state" id="state">                                        	
                                        </div>  
                                        <div class="large-12 column">
                                            <label for="expiry-date" >* Expiry date</label>
                                            <div class="clear"></div>
                                            <div class="large-4 column no-pad-left">
                                                <select name="card-type" id="card-type">
                                                    <option >Month...</option>
                                                    <option value="01">January</option>    
                                                    <option value="02">February</option>
                                                    <option value="03">March</option>    
                                                    <option value="04">April</option>
                                                    <option value="05">May</option>    
                                                    <option value="06">June</option>
                                                    <option value="07">July</option>    
                                                    <option value="08">August</option>
                                                    <option value="09">September</option>    
                                                    <option value="10">October</option> 
                                                    <option value="11">November</option>    
                                                    <option value="12">December</option>                                                                                                       
                                                </select>        
                                           </div>
                                            <div class="large-4 column no-pad-left float-left">
                                                <select name="card-type" id="card-type">
                                                    <option >Year...</option>
                                                    <option value="2014">2014</option>
                                                    <option value="2015">2015</option>
                                                    <option value="2016">2016</option>
                                                    <option value="2017">2017</option>
                                                    <option value="2018">2018</option>
                                                    <option value="2019">2019</option>
                                                    <option value="2020">2020</option>
                                                </select>        
                                           </div>                                           
                                        </div> 
                                        <div class="clear"></div>  
                                        <div class="large-4 column">
                                            <label for="csc" >* Card Verification Code</label>
                                            <input type="text" name="csc" id="csc">                                               	
                                        </div> 
                                        <div class="clear"></div>
                                    </div>
                                </div>        
                                <div class="large-12 column">
                                	<div class="shipping-box column">
                                        <input type="radio" id="paypal" name="payment-method">
                                        <label class="inline" for="paypal">PayPal</label>
                                    </div>    
                                </div>                                                                                                                    
                                <input type="submit" value="continue" class="button"> 
                         	 </div>         
                    </div>    
                </div>  
            	5
            	<div class="large-12 column toggle">                            
                    <li class="toggle-trigger">
                        <div class="step-title">
                            <h2>5/ Order Review</h2>
                        </div>
                   </li>     
                    <div id="checkout-step-review" class="toggle-content column">
                        <div class="large-12 column">  
                            <table class="cart">
                                <thead>
                                    <tr>
                                        <th class="text-left">ITEM DESCRIPTION</th>
                                        <th>PRICE</th>
                                        <th>QTY</th>
                                        <th>SUBTOTAL</th>
                                    </tr>
                                </thead>
            
                                <tbody>
                                    <tr>
                                        <td class="text-left">
                                        <p>
                                            <strong>Cruise RS909</strong>
                                            <br>
                                            <strong>Colour:</strong> Matt Black Frames/ Smoke Grey
                                        </p></td>
                                        <td class="price">$69.95</td>                                                
                                        <td class="">1</td>
                                        <td class="price sale"><span class="price">$139.95</span><span class="sale-price">$69.95</span></td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                        <p>
                                            <strong>Cruise RS909</strong>
                                            <br>
                                            <strong>Colour:</strong> Matt Black Frames/ Smoke Grey
                                        </p></td>
                                        <td class="price">$69.95</td>
                                        <td class="">1</td>
                                        <td class="price">$69.95</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                        <p>
                                            <strong>Cruise RS909</strong>
                                            <br>
                                            <strong>Colour:</strong> Matt Black Frames/ Smoke Grey
                                        </p></td>
                                        <td class="price">$69.95</td>                                                
                                        <td class="">1</td>
                                        <td class="price">$69.95</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left">
                                        <p>
                                            <strong>Cruise RS909</strong>
                                            <br>
                                            <strong>Colour:</strong> Matt Black Frames/ Smoke Grey
                                        </p></td>
                                        <td class="price">$69.95</td>                                                
                                        <td class="">1</td>
                                        <td class="price">$69.95</td>
                                    </tr>
                                    <tr class="subtotal">
                                        <td class="text-left">
                                        <p>
                                            <strong>SUBTOTAL</strong>
                                        </p></td>
                                        <td class="no-border"></td>                                                
                                        <td class="no-border"></td>
                                        <td class="price">$69.95</td>
                                    </tr>   
                                    <tr class="subtotal">
                                        <td class="text-left">
                                        <p>
                                            <strong>SHIPPING</strong>
                                        </p></td>
                                        <td class="no-border"></td>                                                
                                        <td class="no-border"></td>
                                        <td class="price">FREE</td>
                                    </tr>      
                                    <tr class="grand-total">
                                        <td class="text-left">
                                        <p>
                                            <strong>GRAND TOTAL</strong>
                                        </p></td>
                                        <td class="no-border"></td>                                                
                                        <td class="no-border"></td>
                                        <td class="price">$209.85</td>
                                    </tr>                                                                                                                                       
                                </tbody>
                            </table> 
                            <input type="submit" value="PLACE ORDER" class="button"> 
                        </div> 
                    </div>    
                </div>                          
           </ol>
            -->
        </div>
        
        <div class="large-3 column no-pad-right" #checkout-progress>
			<div class="button" id="checkout-progress-top">CHECKOUT PROGRESS</div>
            
            <div class="progress-head">
            	YOUR DETAILS
            </div>
            <div class="progress-info">
            	<p class="address">
                	John Smith<br>85 Smith Street<br>WOLLONGONG, NSW, 2500<br>Australia<br>T:02 9955 4433
                </p>    
            	<a href="/" class="button small-button">EDIT</a>
            </div>    
            
            <div class="progress-head">
            	SHIPPING
            </div>
            <div class="progress-info">
            	<p class="address">
                	John Smith<br>85 Smith Street<br>WOLLONGONG, NSW, 2500<br>Australia<br>T:02 9955 4433
                </p>   
                 <p class="border-top cond bold">STANDARD SHIPPING</p>
            	<a href="/" class="button small-button">EDIT</a>
            </div>     
            
            <div class="progress-head">
            	PAYMENT INFORMATION
            </div>
            <div class="progress-info">
            	<p>Mastercard</p>
                <p class="address">Credit Card Number<br><span class="bbb">XXXX - 1234</span></p>    
            	<a href="/" class="button small-button">EDIT</a>
            </div>  
            
            <div class="progress-head active">
            	ORDER REVIEW
            </div>                                           
                                                
    	</div>
    </div>
        
</div>