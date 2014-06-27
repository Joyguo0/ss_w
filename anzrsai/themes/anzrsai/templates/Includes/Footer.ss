<footer> 
  	<div class="row margin-top-bottom">
        <div class="large-3 columns" id="footer-details">
            $SiteConfig.FooterBottomContent1
            <% if SiteConfig.LinkedInLink %><a href="$SiteConfig.LinkedInLink"><img class="footer-social" src="$ThemeDir/images/facebook-icon-white.png" alt="Follow ANZRSAI on Facebook">Follow us on Facebook</a><% end_if %>
        </div>
		<div class="footer-links-dropdown">
			<h5>Quick Links</h5>
			<form>
			    <select id="footer-links-drop" name="menu" onChange="window.document.location.href=this.options[this.selectedIndex].value;" value="GO">
			        <option selected="selected">Select one...</option>
			    </select>
			</form>
		</div>
        <div class="large-3 columns footer-links">
            $SiteConfig.FooterQuickLinks1
        </div>
        <div class="large-3 columns footer-links">
            $SiteConfig.FooterQuickLinks2
        </div>
        <!-- Contact Details -->
        <div class="large-3 columns last">
        	$SiteConfig.FooterBottomContent2
            <div class="search-box">
                <% if $NewsletterSignUpForm %>
                    <% with $NewsletterSignUpForm %>
                        <form id="Form_Form" $FormAttributes>
                            <input type="text" class="search-input"  name="Email" id="Form_Form_Email" placeholder="Email">
                            <input type="submit" value="Sign Up" name="action_doSubscribe" id="Form_Form_action_doSubscribe" class="search-button">
                            
                            <% loop $Fields %>
                                <% if $Name == SecurityID %>
                                    $FieldHolder
                                <% end_if %>
                            <% end_loop %>
                        </form>
                    <% end_with %>
                <% else %>
                    <a href="#Form_Form">Click here.</a>
                <% end_if %>        
            </div>	
      </div> 	
      <div class="large-12 columns text-center copyright">
      	$SiteConfig.FooterBottomContent3
      </div>          
</footer>