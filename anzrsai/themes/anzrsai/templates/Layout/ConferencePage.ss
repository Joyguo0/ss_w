<% include Slideshow %>
<% include BreadCrumbs %>   
<!-- standard Content 1 - 2 col-->
 
<div class="row" id="content">

    <% include SideBar %>

    <div class="<% if $PageBannersSource != "Hide" %>large-9<% else %>large-12<% end_if %> columns event">
        <h2>$Title</h2>
        
        <% if $ClickForReg %>
            <% if $ConferenceMultiForm %>
                <% include ConferenceRegProgress %>
                
                <% if not $CurrentMember %>
                <% if $ConferenceMultiForm.CurrentStep.ClassName == ConferenceThirdFormStep %>
                    <h3 class="event-form-heads">Member Sign In</h3>
                    
                    <div class="large-6 large-offset-2 columns">
                        <form action="Security/LoginForm" method="post" enctype="application/x-www-form-urlencoded">                  
                            <input type="hidden" name="BackURL" value="{$ConferenceMultiForm.DisplayLink}?MultiFormSessionID={$ConferenceMultiForm.Session.Hash}" class="hidden" id="MemberLoginForm_LoginForm_BackURL">
                        
                            <label for="email" class="contact side">Email</label>
                            <input name="Email" type="email" id="email" class="contact side">
                        
                            <label for="password" class="contact side">Password</label>
                            <input name="Password" type="password" id="password" class="contact side">
                          
                            <a href="Security/lostpassword" class="forgot-pass">I forgot my Password</a>   
                                                                 
                            <input type="submit" value="Sign In" class="button contact">
                        </form>
                    </div>
                <% end_if %>
                <% end_if %>
                
                $ConferenceMultiForm
            <% else %>    
                <% if $ShowSummary %>
                    
                    <% include PaymentSuccessSummary %>
                    
                <% else %>
                    $Content
                <% end_if %>    
            <% end_if %>    
            
        <% else %>
            <h3>Event Details <span>$StartDate.Format(j F Y) - $EndDate.Format(j F Y)</span></h3>
            
            $FullAddressHTML
            
            <% include ConferenceSubBox %>
            
            $Content
            
            <% include ResourcesBox %>
        <% end_if %>
    </div>
    
</div>

