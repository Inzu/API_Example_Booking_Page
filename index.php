<?php

//Load includes
include("config.php");  /// This is where your API Key is stored

//Get venue ID
$venue_id = "165"; //Set this dynamically or to a venue id

//Request data from Inzu about the selected venue
$json = file_get_contents("$api_base/booking/venue?api_key=$api_key&id=$venue_id");
$inzu = json_decode($json); 

//Get the booking calendar Javascript widget from Inzu (populated with venue availability)
$inzu_date_selector = file_get_contents("$api_base/js/calendar/date_selector.js?api_key=$api_key&id=$venue_id&month_auto=true");


?>

<html>
<head>
<link href="style.css" rel="stylesheet" type="text/css" />
<link href="calendar.css" rel="stylesheet" type="text/css" />
</head>
	
<h2>Tickets</h2>

<h3><?php echo $inzu->data[0]->title; ?> - <?php echo $inzu->data[0]->location; ?></h3>
<div id="dateSelect">
<script type="text/javascript">
<?php echo $inzu_date_selector; ?>

//Create a new calendar instance (including availability data)

var mySelector = new INZU_dateSelector({'location':'<?php echo $loc; ?>','currency':'<?php echo $currency; ?>','targetElem':'dateSelect','forward_btn':'img/month_fwd.png','backward_btn':'img/month_bwd.png','this_month':'hide'});

//targetElem refers to the HTML element ID where the calendar will be placed 

//mySelector is extended in ticket_form.js to interact with form for adding tickets

</script>
<script type="text/javascript" src="ticket_form.js"></script>
</div>


<body>

<div id="ticket-select" style="margin-top:16px;">

<form action="tickets_process.php" method="post">

<table width="100%" border="0" cellspacing="0" cellpadding="0" >

	<thead id="ticket-head">
		<tr>
			<th align="left">Tickets</th>
			<th width="72" align="center">Quantity</th>
			<th width="100" align="right">Price</th>
		</tr>
	</thead>
	
	<tfoot id="ticket-total">
		<tr>
			<td align="left"></td>
			<td align="center"><strong>Total:</strong></td>
			<td align="right" id="basketTotal"><?php echo $currency; ?>0.00</td>
		</tr>
	</tfoot>
	
	<tbody id="ticket-selected">
		<tr>
			<td align="left">Please select a date from the calendar...</td>
			<td align="center"><input type="text" maxlength="3" style="width:20px;" /></td>
			<td align="right"><?php echo $currency; ?>0.00</td>
		</tr>
	</tbody>

</table>

<input name="ticket_date" id="ticket_date" type="hidden"  />
<input name="variations" id="variations" type="hidden" />
<input name="dateSel" id="dateSel" type="hidden" />
<input type="submit" style="float:right;margin-top:6px;margin-bottom:6px;" />

</form>

</div>

</body>
</html>