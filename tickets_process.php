<?php
	
//Load includes
require("functions.php"); 
require("config.php");  /// This is where your API Key is stored

$sale = "";

$ticket_date = preg_replace("/[^0-9-]/", "", @$_POST['ticket_date']); //The date selected from the calendar

$variations = preg_replace("/[^0-9,]/", "", @$_POST['variations']); //The variations list for the selected date

$variations = explode(",", $variations);

foreach ( $variations as $key => $var ) {

	$amt = preg_replace("/[^0-9.]/", "", @$_POST['amount_'.$var]); //The amount of tickets selected for that variation by the user
	
	if ( $amt > 0 ) $sale.= $var."_".$amt."=";
	
	$amt = 0;

}


///The forwarding URL to the INZU checkout pages

//u = the public id of the INZU user
//id = the id of the ticket venue/envent entry
//sale = the number of tickets and variation type
//date = the date selected for tickets
//calendar = if not set to hide a selection calendar is displayed on the INZU checkout page
//callback = a callback URL for a completed transaction


header("Location: {$pay_url}booking?u=1ffa420ebd31c45d5b7d073cdb011be2&id=165&sale=$sale&date=$ticket_date&calendar=hide&callback=$pay_callback&loc=$loc");


?>
