<?php
	
// Load Includes

require("functions.php"); 
require("config.php");  

$booking_date = preg_replace("/[^0-9-]/", "", $_POST['booking_date']); // The date selected from the calendar
$variations_amt = preg_replace("/[^0-9]/", "", $_POST['variations']); // The number of variations the selected date has

$delimiter = "";

for ( $i = 0; $i < $variations_amt; $i++ ) {

	$amt = preg_replace("/[^0-9.]/", "", @$_POST['amount_'.$i]); // The amount of bookings selected for that variation by the user
	
	if ( $amt > 0 ) $sale.= $i."_".$amt.$delimiter;
	
	$delimiter = "=";
	
	$amt = 0;

}

/* 
	
Generate URL for the Inzu payment gateway
	
u = the public id of the Inzu account
id = the id of the venue
sale = the number of bookings and variation type
date = the date selected
calendar = if not set to hide a selection calendar is displayed on the Inzu checkout page
callback = a callback URL for a completed transaction

*/

header("Location: https://payments.inzu.net/booking?u=1ffa420ebd31c45d5b7d073cdb011be2&id=165&sale=$sale&date=$booking_date&calendar=hide&callback=https://inzu.net/");

?>