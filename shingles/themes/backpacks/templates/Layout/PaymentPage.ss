<% if $PaymentMultiForm %>
    <div class="multistep">
        <div class="onepcssgrid-1140">
            <div class="col12">
                <div id="form-steps">
                    <% loop $PaymentMultiForm.StepsProgress %>
                        <a class="$StepLinkingMode<% if $isFinalStep %> last<% end_if %>" href="#">$StepTitle</a>
                    <% end_loop %>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                
            </div>
        </div>
    </div>
<% end_if %>

<div class="payment-form">
    <div class="onepcssgrid-1140">
        
        <div class="col3"><div style="height:1px;width:1px;"></div></div><!-- Spacer -->
        
        <!-- Content Bit -->
        <div class="col6">
            <div class="content<% if $PaymentMultiForm %> $PaymentMultiForm.getCurrentStep.ClassName<% end_if %>">
                <% if $PaymentMultiForm %>
                    $PaymentMultiForm
                <% else %>
                    $Content
                
                    $Form
                <% end_if %>
            </div>
        </div>
        
        <div class="col3 last"><div style="height:1px;width:1px;"></div></div><!-- Spacer -->
        
        <div class="clear"></div>
        
  </div>
</div>

<div id="loading-popup" class="ui-widget-overlay">
    <div id="loading-text">
        <div id="loading-indicator" class="ui-corner-all">
        </div>
    
        <span>Processing...</span>
        <h2>Please wait until the payment has been fully processed. This may take up to 60 seconds</h2>
    </div>
    
</div>
