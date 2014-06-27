<% if $EventDetails %>
    <div class="row">
         <div class="large-6 columns">
             <table class="event-details">
                <tbody>
                    <% loop $EventDetails %>
                        <tr>
                            <td class="strong">$Title</td>
                            <td class="light">$Content</td>
                        </tr>
                    <% end_loop %>
               </tbody>
            </table>   
        </div>     
    </div>
<% end_if %>

<div class="row sub-banners">
    <div class="large-4 columns sub-box">
        <img alt="Whats Hot" title="content image" src="$ThemeDir/images/icon-most-cited.png">
        <h2>Submit Your<br>Abstract</h2>
        <a href="$LoadAbstractUploadPage.Link">READ MORE &raquo;</a>
    </div>
    <div class="large-4 columns sub-box">
        <img alt="content image" title="content image" src="$ThemeDir/images/icon-conference.png">
        <h2>Register for <br> $Title</h2>
        <a href="$Link(reg)">REGISTER &raquo;</a>
    </div>
    <div class="large-4 columns sub-box">
        <img alt="content image" title="content image" src="$ThemeDir/images/icon-become-member.png">
        <h2>Become an ANZRSAI<br>Member</h2>
        <a href="$LoadSignUpPage.Link">READ MORE &raquo;</a>
    </div>  
</div>