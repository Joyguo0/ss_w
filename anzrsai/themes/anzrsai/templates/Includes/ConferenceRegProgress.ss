<% loop $ConferenceMultiForm %>
    <div class="large-12 columns">
        <ul class="event-steps block-grid-7">
            <li class="<% if $CurrentStep.ClassName == ConferenceFirstFormStep %>active<% end_if %>"><a href="#">1</a></li>
            
            <li class="divider"></li>
            
            <li class="<% if $CurrentStep.ClassName == ConferenceSecondFormStep %>active<% end_if %>"><a href="#">2</a></li>
            
            <li class="divider"></li>
            
            <li class="<% if $CurrentStep.ClassName == ConferenceThirdFormStep %>active<% end_if %>"><a href="#">3</a></li>
            
            <li class="divider"></li>
            
            <li class="<% if $CurrentStep.ClassName == ConferenceFouthFormStep %>active<% end_if %>"><a href="#">4</a></li>
        </ul>
    </div>
<% end_loop %>    