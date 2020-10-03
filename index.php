<?php

// Load Includes

include("functions.php");
include("config.php");

// Venue ID

$venue_id = "165";

// Get API Data

$arguments = array("venue_id"=>$entry_id);
$inzu = INZU_GET("booking/venue", $arguments);

// Get Calendar  Widget

$arguments = array("venue_id"=>$venue_id, "month_auto"=>"true");
$inzu_calendar = INZU_GET("js/calendar/calendar.js", $arguments, "raw");

?>
<html>
<head>
	<link href="style.css" rel="stylesheet" type="text/css" />
	<link href="booking_calendar.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<h2>Tickets</h2>
	<h3><?php echo $inzu->data[0]->title; ?> - <?php echo $inzu->data[0]->location; ?></h3>
	<div id="calendar">
		<script type="text/javascript">
			<?php echo $inzu_calendar; ?>
			
			// Create a new calendar instance
			
			/* 
			targetElem refers to the HTML element ID where the calendar will be placed 
			calendar is extended in booking_form.js to interact with form for adding tickets
			*/
			
			var calendar = new INZU_calendar({'location':'<?php echo $loc; ?>','currency':'<?php echo $currency; ?>','targetElem':'calendar','forward_btn':'img/month_fwd.png','backward_btn':'img/month_bwd.png'});	
				
		</script>
		<script type="text/javascript" src="booking_form.js"></script>
	</div>
	<div id="booking-select" style="margin-top:16px;">
		<form action="booking_process.php" method="post">
		<table width="100%" border="0" cellspacing="0" cellpadding="0" >
			<thead id="booking-head">
				<tr>
					<th align="left">Tickets</th>
					<th width="72" align="center">Quantity</th>
					<th width="100" align="right">Price</th>
				</tr>
			</thead>	
			<tfoot id="booking-total">
				<tr>
					<td align="left"></td>
					<td align="center"><strong>Total:</strong></td>
					<td align="right" id="basketTotal"><?php echo $currency; ?>0.00</td>
				</tr>
			</tfoot>	
			<tbody id="booking-selected">
				<tr>
					<td align="left">Please select a date from the calendar...</td>
					<td align="center"><input type="text" maxlength="3" style="width:20px;" /></td>
					<td align="right"><?php echo $currency; ?>0.00</td>
				</tr>
			</tbody>
		</table>
		<input name="booking_date" id="booking_date" type="hidden"  />
		<input name="variations" id="variations" type="hidden" />
		<input name="dateSel" id="dateSel" type="hidden" />
		<input type="submit" style="float:right;margin-top:6px;margin-bottom:6px;" />
		</form>
	</div>
</body>
</html>