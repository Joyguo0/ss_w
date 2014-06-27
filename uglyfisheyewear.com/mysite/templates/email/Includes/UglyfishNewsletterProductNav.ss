<% if $Newsletter.isMainSite && $Newsletter.AllProductCategories %>
    <!-- start main nav-->
        <table width="700" align="center" border="0" cellspacing="0" cellpadding="0" style="background-color: #d12421; border: 0; width: 700px; border-collapse:collapse; font-size: 14px;">
            <tbody>
                <tr> 
                	
                <% loop $Newsletter.AllProductCategories %>

					<td style="padding-top: 10px; padding-bottom: 10px; background-color: #d12421; <% if First %> <% else %>border-left: 1px solid #fff; <% end_if %>text-align:center; ">
                    	<a href="$Link" style="color: #fff; font-family:'Trebuchet MS', Arial, Helvetica, sans-serif; text-decoration:none;">
                    		<% if $SppMenuTitle %>$SppMenuTitle<% else %>$Title<% end_if %>
						</a>   
                    </td>
                        
                <% end_loop %>
             </tr>
           </tbody>
      </table>   
    <!-- end main nav-->

<% end_if %>