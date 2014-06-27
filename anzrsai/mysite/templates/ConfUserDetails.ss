<% loop $Record %>
    <div class="large-6 columns">
         <table class="event-details">
            <tbody>
                <tr>
                    <td class="strong right">Title</td>
                    <td class="light">$MemberTitle</td>
                </tr>
                <tr>
                    <td class="strong right">First Name</td>
                    <td class="light">$FirstName</td>
                </tr>
                <tr>
                    <td class="strong right">Last Name</td>
                    <td class="light">$Surname</td>
                </tr>
                <tr>
                    <td class="strong right">Organisation</td>
                    <td class="light">$Organisation</td>
                </tr>
                <tr>
                    <td class="strong right">Position</td>
                    <td class="light">$Position</td>
                </tr>   
                <tr>
                    <td class="strong right">Mobile Phone</td>
                    <td class="light">$MobilePhone</td>
                </tr>   
                <tr>
                    <td class="strong right">Home Phone</td>
                    <td class="light">$HomePhone</td>
                </tr>                                                                                        
           </tbody>
         </table>    
    </div>
    
    <div class="large-6 columns">
         <table class="event-details">
            <tbody>
                <tr>
                    <td class="strong right">Email</td>
                    <td class="light">$Email</td>
                </tr>
                <tr>
                    <td class="strong right">Address Line 1</td>
                    <td class="light">$AddressLine1</td>
                </tr>
                <tr>
                    <td class="strong right">Address Line 2</td>
                    <td class="light">$AddressLine2</td>
                </tr>
                <tr>
                    <td class="strong right">City</td>
                    <td class="light">$City</td>
                </tr>
                <tr>
                    <td class="strong right">State</td>
                    <td class="light">$State</td>
                </tr>
                <tr>
                    <td class="strong right">Postcode</td>
                    <td class="light">$Postcode</td>
                </tr>   
                <tr>
                    <td class="strong right">Country</td>
                    <td class="light">$Country</td>
                </tr>                                                                                     
           </tbody>
         </table>      
    </div>
<% end_loop %>