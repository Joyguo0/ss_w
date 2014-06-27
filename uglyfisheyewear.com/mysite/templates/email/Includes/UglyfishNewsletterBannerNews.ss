<% if $SiteConfig.BannerNews %>
    
    <table width="680" align="center" border="0" cellspacing="0" cellpadding="0" style="border: 0; width: 680px; padding-bottom: 10px;">
        <tbody style="background-color: #111111;">
            <tr>
                <td align="center" style="padding-top: 1px; padding-left: 1px; padding-bottom: 1px; padding-right: 1px; background-color: #111111;">
                    <table  width="676px" style="width: 676px;">
                        <tbody>
                            <tr>
                                <td style="padding-top: 5px; padding-left: 2px; padding-bottom: 5px; padding-right: 2px; background-color: #111111; border: 2px solid #fff; text-align:center;">
                                <a href="$SiteConfig.BannerNews.getLinkURL" style="text-align: center; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; font-weight: bold; color: #ffffff; padding-top: 3px; padding-bottom:3px; text-decoration:none;">
                                	$SiteConfig.BannerNews.Title &raquo; 
                                </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
           </tr>
        </tbody>
   </table>
    
<% end_if %>    