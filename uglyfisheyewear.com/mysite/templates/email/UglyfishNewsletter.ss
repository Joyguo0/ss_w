<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>UOW - Airport Pickup - Confirmation Email</title>
<script type="text/javascript" src="http://w.sharethis.com/button/buttons.js"></script>
</head>

<body style="background-color: #f3f3f3; margin-top: 20px; margin-bottom: 20px;">
       
   <!-- START TABLE -->
       
        <table width="700" align="center" border="0" cellspacing="10" cellpadding="10" style="background-color: #000000; border: 0; width: 700px;">
            <tbody>
                <tr>
                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><img src="$SiteConfig.Toplogo.url()" style="width: 200px;"/></td>
                    <td cellSPACING="10" width="300" style="width: 300px;"></td>
                    <td cellSPACING="10" width="200" style="width: 200px;">
                         <table>
                         	<tbody>
                                <tr>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.FacebookLink" target="_blank"><img src="themes/uglyfisheyewear/images/facebook.png" style="width: 37px;"/></a></td>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.TwitterLink" target="_blank"><img src="themes/uglyfisheyewear/images/twitter.png" style="width: 37px;"/></a></td>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.GooglePlusLink" target="_blank"><img src="themes/uglyfisheyewear/images/instagram.png" style="width: 37px;"/></a></td>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.YouTubeLink" target="_blank"><img src="themes/uglyfisheyewear/images/youtube.png" style="width: 37px;"/></a></td>
                                </tr>
                         	</tbody>
                         </table>                         
                    </td>
               </tr>
            </tbody>
         </table>

     <!-- red nav section -->      

     <% include UglyfishNewsletterProductNav %>
                                         
     <!-- newsletter body -->      
        
        <table width="700" align="center" border="0" cellspacing="10" cellpadding="8" style="background-color: #d2d3d5; border: none;">
        	<tbody style=" padding-top: 10px; padding-left: 10px; padding-bottom: 10px; padding-right: 10px">          	
            	<tr>
                	<td cellspacing="10" cellpadding="0" style=" padding-top: 0; padding-left: 0; padding-bottom: 0; padding-right: 0;">

     			<!-- top banner link -->      

                        <% include UglyfishNewsletterBannerNews %>
                       
     			<!-- top hero banner -->      
                       
                        <table width="680" align="center" border="0" cellspacing="0" cellpadding="0" style="border: 0; width: 680px; font-family:Arial, Helvetica, sans-serif; padding-bottom: 10px;">
                            <tbody>
                                <tr>
                                    <td align="left" style="padding-top: 1px; padding-left: 1px; padding-bottom: 1px; padding-right: 1px; background-color: #ffffff">
                                        <table cellspacing="5" cellpadding="5" width="340px" style="width: 340px">
                                            <tbody>
                                                <tr>
     											<!-- MAIN HEADING FOR BANNER -->      
                                                    <td style="text-align:left; font-size: 22px; font-weight: bold; color: #d12421;">$Subject</td>
                								</tr>
                                                <tr>	
                                                    <td style=" font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #484848; text-decoration:none; font-weight: normal; line-height: 22px; padding-bottom: 20px;">
                                                    	 $Body
                                                    </td>
                                                </tr>
                                                <tr>
                   								   	<td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em; padding-bottom: 20px;">
                   								   		<a href="/" style="color: #000000; padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-bottom: 10px; border: 1px solid #000000;text-decoration: none; font-size: 14px; font-weight: bold;">VIEW NOW &raquo;</a>
                                                   	</td>
                                                </tr>    
                                            </tbody>
                                        </table>
                                    </td>
                                    <td align="center" style="padding-top: 1px; padding-left: 1px; padding-bottom: 1px; padding-right: 1px; background-color: #ffffff">
                                    	<!-- <img src="images/hero-image.jpg"/>-->
                                    	$Newsletter.Toplogo.ResizedImage(285,178)
                                    </td>
                               </tr>
                            </tbody>
                       </table>
                       
                       
                        <table width="680" align="center" border="0" cellspacing="0" cellpadding="0" style=" border-top: 2px solid #d12421; width: 680px; font-family:Arial, Helvetica, sans-serif;">
                            <tbody>
                                <tr>
                                    <td align="left" style="padding-top: 5px; padding-left: 10px; padding-bottom: 5px; padding-right: 10px; color: #ffffff; font-weight: bold; background-color: #111111;">
                                    	PRODUCTS HEADING
                                    </td>
                               </tr>
                           </tbody> 
                       </table>
                       
                       <table width="680" align="center" style="padding-bottom: 10px;">
                            <tr>	       
                                <td style="background: #ffffff;">
                                    <table cellspacing="5" cellpadding="5">
                                    	
                                    		
                                			
                                			<% loop $Newsletter.RelatedProducts %>
                                			<% if $Pos == 1 || $Pos == 4 %><tr><% end_if %>
                                			
	                                    		<td style="vertical-align:top">
	                                            	<table>
	                                                    <tr>
	                                                        <a href="$Link">
	                                                        
																<% if getProductThumbnail.exists() %>
																	$getProductThumbnail.ResizedImage(200,150)
                        										<% end_if %>
	                                                        	
	                                                        </a>
	                                                    </tr>
	                                                    <tr><td style="font-family:Arial, Helvetica, sans-serif; font-size: 12px; color: #111111; font-weight: bold; line-height:14px;">$Title</td></tr>  
	                                                    <tr><td style="font-family:Arial, Helvetica, sans-serif; font-size: 11px; color: #666666; text-decoration:line-through">$Price.Nice</td></tr>
	                                                    <tr><td style="font-family:Arial, Helvetica, sans-serif; font-size: 11px; color: #d12421;">$Price.Nice</td></tr>
	                                                </table>                                                     
	                                            </td>
											
                                			<% if $Pos == 3 || $Pos == 6 %></tr><% end_if %>
                                      		<% end_loop %>
                                  	</table>  
                                </td>
                           </tr>
                       </table> 
                       <% loop $Newsletter.NewsletterStorys %>
                       		<table width="680" align="center" border="0" cellspacing="0" cellpadding="0" style=" border-top: 2px solid #d12421; width: 680px; font-family:Arial, Helvetica, sans-serif;">
	                            <tbody>
	                                <tr>
	                                    <td align="left" style="padding-top: 5px; padding-left: 10px; padding-bottom: 5px; padding-right: 10px; color: #ffffff; font-weight: bold; background-color: #111111;">
	                                    	$Title
	                                    </td>
	                               </tr>
	                           </tbody> 
	                       </table>
	                       <table width="680" align="center" style="padding-bottom: 10px; font-family:Arial, Helvetica, sans-serif;">
	                            <tr>	       
	                                <td style="background: #ffffff;">
	                                    <table cellspacing="5" cellpadding="5">
	                                    	<tr>
	                                        	<td width="500" style="width: 500px;">
	                                            	<table>
	                                                    <tr>
		                                                    <td style=" font-family: Arial, Helvetica, sans-serif; font-size: 12px; color: #111111; text-decoration:none; font-weight: normal; line-height: 16px; padding-bottom: 20px;">
		                                                    	$Content
		                                                    </td>
	                                                    </tr>
	                                                    <tr>
	                                                      	<td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em; padding-bottom: 20px;">
		                                                       	<a href="$Link" style="color: #000000; padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-bottom: 10px; border: 1px solid #000000;text-decoration: none; font-size: 14px; font-weight: bold;">
		                                                       		VIEW NOW &raquo;
		                                                       	</a>
	                                                       	</td>
	                                                    </tr>    
	                                                </table>    
	                                            </td>
	                                            <td style="vertical-align:top;">
	                                            	$Image.ResizedImage(200,150)
	                                            </td>    
	                                        </tr>
	                                   </table>
	                               </td>
	                           </tr>                                                              
	                       </table>
                       <% end_loop %>
                                        
 					</td>
                </tr>
           </tbody>
       </table>             
                                
   <!-- FOOTER STARTS ---->     
                 
        <table width="700" align="center" border="0" cellspacing="1" cellpadding="10" style="text-align: center; font-family: Arial, Helvetica, sans-serif; background-color: #111111; border-top: 2px solid #d12421; width: 700px; font-size: 11px; text-decoration: underline;">
            <tbody>
                <tr>
                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;">
                    	<img src="$SiteConfig.Toplogo.url()" style="width: 200px;"/>
                    </td>
                    <td>
                         <table>
                         	<tbody>
                                <tr>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.FacebookLink" target="_blank"><img src="themes/uglyfisheyewear/images/facebook.png" style="width: 37px;"/></a></td>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.TwitterLink" target="_blank"><img src="themes/uglyfisheyewear/images/twitter.png" style="width: 37px;"/></a></td>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.GooglePlusLink" target="_blank"><img src="themes/uglyfisheyewear/images/instagram.png" style="width: 37px;"/></a></td>
                                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="$SiteConfig.YouTubeLink" target="_blank"><img src="themes/uglyfisheyewear/images/youtube.png" style="width: 37px;"/></a></td>
                                </tr>
                         	</tbody>
                         </table>      
                    </td>
                    <td cellSPACING="10" width="200" style="width: 200px;padding-right: 1em; margin-right: 1em;"><a href="/" style="color: #ffffff; padding-left: 20px; padding-right: 20px; padding-top: 10px; padding-bottom: 10px; border: 1px solid #ffffff;text-decoration: none; font-size: 14px;">UGLYFISHEYEWEAR.COM</a></td>
               </tr>
            </tbody>
       </table>  

        <table width="700" align="center" border="0" cellspacing="1" cellpadding="5" style="text-align: center; font-family: Arial, Helvetica, sans-serif; background-color: #000000; width: 700px; font-size: 11px;">
            <tbody>
                <tr>
      				 <td style="width: 700px; font-size: 10px; color: #999999; text-align:center;">You have recieved this message because you either completed a form on <a href="/" style="color: #d12421; text-decoration: underline;">uglyfisheyewear.com</a> or have an existing account with us. If you believe this email should not have gone to you please <a href="/" style="color: #d12421; text-decoration: underline;">contact us</a>. We take our customer¡®s privacy seriously and we will only collect and use your personal information as outlined in our <a href="/" style="color: #d12421; text-decoration: underline;">Privacy Policy</a>. Our Privacy Statement fully complies with the Privacy Act 1988 and represents the industry¡¯s best practice.</td>           
    			</tr>
           </tbody>
      </table>         
       
</body>
</html>
