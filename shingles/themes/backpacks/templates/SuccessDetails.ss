<h2>Ref #: $InvoiceReference</h2>
<h4 style="color:#002642; padding-left:60px;">Amount: $ $Amount</h5>
<br />
<h2>Contact Details</h2>
<% with Customer %>
	<p style="padding-left:60px;">Title: <strong>$Title</strong></p>
	<p style="padding-left:60px;">FirstName: <strong>$FirstName </strong></p>
	<p style="padding-left:60px;">Last Name: <strong>$LastName </strong></p>
	<p style="padding-left:60px;">Email: <strong>$Email </strong></p>
	<% if Phone %><p style="padding-left:60px;">Phone: <strong>$Phone </strong></p><% end_if %>
	<% if Street %><p style="padding-left:60px;">Street: <strong>$Street </strong></p><% end_if %>
	<% if City %><p style="padding-left:60px;">City: <strong>$City </strong></p><% end_if %>
	<% if State %><p style="padding-left:60px;">State: <strong>$State </strong></p><% end_if %>
	<p style="padding-left:60px;">Postcode: <strong>$PostalCode </strong></p>
<% end_with %>

<h2>Payment Details:</h2>

<% with TokenDetails %>
	<p style="padding-left:60px;">Card Name: <strong>$CardName </strong></p>
	<p style="padding-left:60px;">Card Number: <strong>$CardNumber </strong></p>
<% end_with %>

<% with PaymentDetails %>
	<p style="padding-left:60px;">PaymentID: <strong>$ID </strong></p>
	<% if $TransactionID %><p style="padding-left:60px;">TransactionID: <strong>$TransactionID </strong></p><% end_if %>
<% end_with %>