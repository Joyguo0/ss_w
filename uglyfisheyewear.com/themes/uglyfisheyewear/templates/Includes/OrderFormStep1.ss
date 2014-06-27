<% if DetailsFormForStep1 %>
    <!-- checkout step 1 -->
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
                    
                    <form id="checkout-login-form" action="Security/LoginForm" method="post" enctype="application/x-www-form-urlencoded">
                        <div class="large-3 small-4 column">
                            <label for="email" >EMAIL</label>
                        </div>
                        
                        <div class="large-9 small-8 column">
                            <input type="text" name="Email" class="text" id="email" tab-index="0">
                        </div> 
                        
                        <div class="large-3 small-4 column">
                            <label for="password" >PASSWORD</label>
                        </div>
                        
                        <div class="large-9 small-8 column">
                            <input type="password" name="Password" class="text password" id="password" tab-index="0">
                        </div>    
                        
                        <a href="Security/lostpassword" target="_blank" class="small text-right column">I forgot my password</a>
                        
                        <input type="hidden" name="BackURL" value="/admin/pages" class="hidden" id="MemberLoginForm_LoginForm_BackURL">
                        
                        <input type="submit" name="action_dologin" value="sign in & continue" class="action button" id="formdologin">
                    </form>           
                </div>   
            
            
                <div class="large-6 inner column inline uppercase no-pad-right">
                    <h4>NEW CUSTOMER</h4>
                    
                    <p class="cond">An account is not required to shop with us. You can check out as a guest or you can register to save your details for your next purchase.</p>
                    
                    <section class="personal-details">
                        <% loop DetailsFormForStep1 %>
                            $FieldHolder
                        <% end_loop %>
                    </section>
                </div>        
            </div>            
        </div>
    </div>
<% end_if %>