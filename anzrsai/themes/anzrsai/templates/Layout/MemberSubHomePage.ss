<% include Slideshow %>
<% include BreadCrumbs %>	
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">

	<div class="large-9 columns">
		<h2>$Title</h2>
		
        <div class="large-6 columns member-signin start">
            <h3>Members Sign In</h3>
            
            <form action="Security/LoginForm" method="post" enctype="application/x-www-form-urlencoded">                  
                <input type="hidden" name="BackURL" value="{$LoadMemberDashBoardPage.Link}" class="hidden" id="MemberLoginForm_LoginForm_BackURL">
            
                <label for="email" class="contact side">Email</label>
                <input name="Email" type="email" id="email" class="contact side">
            
                <label for="password" class="contact side">Password</label>
                <input name="Password" type="password" id="password" class="contact side">
              
                <a href="Security/lostpassword" class="forgot-pass">I forgot my Password</a>   
                                                     
                <input type="submit" value="Sign In" class="float-right button small-button contact">
            </form>
        </div>

		<div class="large-6 columns member-signin last" id="become-member">
		      <h3>$SubTitle</h3>
		      
		      $SubContent
		      
              <form action="$LoadSignUpPage.Link"> 
                <input type="submit" value="Join" class="button small-button contact">
              </form>		  
		</div>
		
		$Content
		
		$Form
		
		<% include ResourcesBox %>
	</div>    
	
	 <% include SideBar %> 
	
</div>

