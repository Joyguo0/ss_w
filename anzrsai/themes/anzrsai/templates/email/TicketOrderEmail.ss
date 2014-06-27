<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>$Subject - $ConferenceTitle</title>
</head>

<body style="background-color: #f3f3f3; margin-top: 20px; margin-bottom: 20px;">
       
   <!-- START TABLE -->
       
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>$Subject - $ConferenceTitle</title>
    </head>

    <body style="background-color: #f3f3f3; margin-top: 20px; margin-bottom: 20px;">

        <!-- START TABLE -->

        <div style="background-color:#f3f3f3;margin-top:20px;margin-bottom:20px">

            <table width="700" align="center" border="0" cellspacing="10" cellpadding="0" style="background-color:#ffffff;border:0;width:700px">
                <tbody>
                    <tr>
                        <td cellspacing="10" width="200" style="width:200px;padding-right:1em;margin-right:1em"><img src="http://anzrsai.ssdev.delta.internetrix.net/themes/anzrsai/images/logo.png" style="width:200px"></td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>

            <table width="700" align="center" border="0" cellspacing="10" cellpadding="0" style="background-color:#ffffff;border:none">
                <tbody style="padding-top:30px;padding-left:10px;padding-bottom:40px;padding-right:10px">
                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:20px;color:#575757;text-decoration:none;line-height:24px">Order Confirmation - Conference 2014</td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#727272;text-decoration:none;font-weight:normal;line-height:24px">$Content&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:16px;color:#575757;text-decoration:none;font-weight:normal;line-height:24px">Your Details</td>
                    </tr>

                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#727272;text-decoration:none;font-weight:normal;line-height:24px">
                            <table  style="width: 100%; border-collapse:collapse">
                                <tbody>
                                    <% loop $Member %>
                                        <tr style="background-color: #f8f8f8; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold; ">Title</td>
                                            <td>$MemberTitle</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold; ">Email</td>
                                            <td><a href="mailto:$Email" target="_blank" style="color:#2a7cb4;text-decoration:none">$Email</a></td>                                        
                                        </tr>
                                        <tr style="background-color: #f0f0f0; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">First Name</td>
                                            <td>$FirstName</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Address Line 1</td>
                                            <td>$AddressLine1</td>                                        
                                        </tr>
                                        <tr style="background-color: #f8f8f8; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Last Name</td>
                                            <td>$Surname</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold; ">Address Line 2</td>
                                            <td>$AddressLine2</td>                                        
                                        </tr>
                                        <tr style="background-color: #f0f0f0; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Organisation</td>
                                            <td>$Organisation</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold; ">City</td>
                                            <td>$City</td>                                        
                                        </tr>
                                        <tr style="background-color: #f8f8f8; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Position</td>
                                            <td>$Position</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">State</td>
                                            <td>$State</td>                                        
                                        </tr>
                                        <tr style="background-color: #f0f0f0; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Mobile Phone</td>
                                            <td>$MobilePhone</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Postcode</td>
                                            <td>$Postcode</td>                                        
                                        </tr>
                                        <tr style="background-color: #f8f8f8; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Home Phone</td>
                                            <td>$HomePhone</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Country</td>
                                            <td>$CountryName</td>                                        
                                        </tr>
                                    <% end_loop %>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                    </tr>
                    
                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:16px;color:#575757;text-decoration:none;font-weight:normal;line-height:24px">Payment Details</td>
                    </tr>
                    
                    
                    <% if $Payment %>
                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#727272;text-decoration:none;font-weight:normal;line-height:24px">
                            <table  style="width: 100%; border-collapse:collapse">
                                <tbody>
                                    <% loop $Payment %>
                                        <tr style="background-color: #f8f8f8; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold; ">Transaction Reference</td>
                                            <td>$MerchTxnRef</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold; ">Transaction Number</td>
                                            <td>$TransactionNo</td>                                        
                                        </tr>
                                        <tr style="background-color: #f0f0f0; border: 1px solid #dddddd;">
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Card Type</td>
                                            <td>$CardTypeName</td>
                                            <td style="color: #484848; padding-left: 5px; font-weight: bold;">Amount</td>
                                            <td>$$AmountNice AUD</td>                                        
                                        </tr>
                                    <% end_loop %>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                    <% end_if %>
                    
                    
                    
                    
                    
                    <tr>
                        <td></td>
                    </tr>       
                    
                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:16px;color:#575757;text-decoration:none;font-weight:normal;line-height:24px">$ItemType</td>
                    </tr>
                    <tr>
                        <td style="font-family:Arial,Helvetica,sans-serif;font-size:14px;color:#727272;text-decoration:none;font-weight:normal;line-height:24px">
                            <table cellspacing="0" cellpadding="0" style="border-spacing: 1px; width: 680px; border-collapse:collapse;">
                                <tbody>
                                    <tr style="background-color: #46acd9;">
                                        <td></td>
                                        <th style="color: #ffffff; font-weight: normal; font-size: 14px; border-1px solid #ffffff; border-collapse: collapse;">Price</th>
                                        <th style="color: #ffffff; font-weight: normal; font-size: 14px; border-1px solid #ffffff; border-collapse: collapse; width:70px;">QTY</th>
                                        <th style="color: #ffffff; font-size: 14px; border-1px solid #ffffff; border-collapse: collapse;">Total</th>
                                    </tr>
        
                                    <% loop $Tickets %>
                                        <tr style="background-color: #f0f0f0;">
                                            <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; padding-left: 5px;" ><strong>$Name</strong>
                                            <br>
                                            $Description</td>
                                            <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; padding-left: 5px;">$$FinalTicketPrice AUD</td>
                                            <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; text-align:center;">$TicketQTY</td>
                                            <td style="border: 1px solid #dddddd; border-collapse:collapse; color: #484848; font-weight: bold; text-align: center;">$$TotalTicketPrice AUD</td>
                                        </tr>
                                    <% end_loop %>
                                </tbody>
                            </table>
                        </td>
                    </tr>

                </tbody>
            </table>

            <table width="700" align="center" border="0" cellspacing="0" cellpadding="0" style="text-align:left;font-family:Arial,Helvetica,sans-serif;background-color:#ffffff;border-top:1px solid #eeeeee;border-bottom:1px solid #eeeeee;width:700px;font-size:14px;text-decoration:none;color:#575757;padding-top:30px;padding-left:10px;padding-bottom:40px;padding-right:10px">

                <tbody>
                    <tr>
                        <td cellspacing="10" width="200" style="width:330px;padding-right:1em;margin-right:1em;padding-bottom:5px">Australia New Zealand Regional</td>
                    </tr>
                    <tr>
                        <td cellspacing="10" width="200" style="width:330px;padding-right:1em;margin-right:1em;padding-bottom:5px">Science Association International</td>
                    </tr>
                    <tr>
                        <td cellspacing="10" width="200" style="width:330px;padding-right:1em;margin-right:1em;padding-bottom:10px;padding-top:10px"><img src="http://anzrsai.ssdev.delta.internetrix.net/themes/anzrsai/images/logo.png" style="width:200px"></td>
                    </tr>
                    <tr>
                        <td cellspacing="10" width="200" style="width:330px;padding-right:1em;margin-right:1em;padding-bottom:5px">ABN - 26 051 521 978</td>
                    </tr>
                </tbody>
            </table>

            <table width="700" align="center" border="0" cellspacing="1" cellpadding="5" style="text-align:center;font-family:Arial,Helvetica,sans-serif;background-color:#ffffff;width:700px;font-size:11px">
                <tbody>
                    <tr>
                        <td style="width:700px;font-size:10px;color:#999999;text-align:center"> You have recieved this message because you either
                        completed a form on <a href="http://anzrsai.org" style="color:#2a7cb4;text-decoration:none" target="_blank">anzrsai.org</a> or have an existing account with us. If you
                        believe this email should not have gone to you please <a href="mailto:anzrsai@anzrsai.org" style="color:#2a7cb4;text-decoration:none" target="_blank">contact us</a>.
                        We take our customerâ€˜s privacy seriously and we will only collect and use
                        your personal information as outlined in our <a href="http://www.anzrsai.org/privacy" style="color:#2a7cb4;text-decoration:none" target="_blank">Privacy Policy</a>. Our Privacy Statement fully
                        complies with the Privacy Act 1988 and represents the industry's best
                        practice. </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </body>
</html>