<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>$Subject</title>
</head>

<body style="background-color: #f3f3f3; margin-top: 20px; margin-bottom: 20px;">
       
    <% include NewsletterHeader %>
 
     <!-- paragraphs -->      
        
    <table width="700" align="center" border="0" cellspacing="10" cellpadding="0" style="background-color: #ffffff; border: none;">
        <tbody style=" padding-top: 30px; padding-left: 10px; padding-bottom: 40px; padding-right: 10px">           
            <tr>
                <td style=" font-family: Arial, Helvetica, sans-serif; font-size: 20px; color: #575757; text-decoration:none; line-height: 24px;">
                    $Subject
                </td>
            </tr>
            
            <tr><td></td></tr>
            
            <tr>
                <td style=" font-family: Arial, Helvetica, sans-serif; font-size: 14px; color: #727272; text-decoration:none; font-weight: normal; line-height: 24px;">
                    $Body
                </td>
            </tr>
       </tbody>
    </table>
                                
    <% include NewsletterFooter %>
    
    <% include UnsubscribeFooter %>
       
</body>
</html>