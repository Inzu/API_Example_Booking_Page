///This file contains an extension of the selectDate prototype of the INZU_dateSelector class and a separate function for adjusting the form totals according to the amount of tickets selected

//You may change and use all of the following code in your projects

//IMPORTANT - This file uses US Dollars for prices please change the &#36; currency symbol accordingly


//------------------//


///Extend selectDate prototype to update form with selected tickets from calendar

mySelector.selectDate = function(dayElement, year, month, day) {

this.day = day;

//Allow selection only on dates that exist this month
if ( dayElement.className == "dpDayAvailableTD" || dayElement.className == "dpTDselected" ) {

//Delete all previously selected tickets from order form
for ( var i = document.getElementById("ticket-selected").rows.length; i>0; i--) {
	
document.getElementById("ticket-selected").deleteRow( i-1 );

}


var day_sel = this.selectedDates[this.year][this.month][this.day].dateVariationsData;

//Create list of variations available on this day

var variations_list = "";


//Loop through list of variations and check availability for selected day

for ( var variation in day_sel ) {

variations_list += variation + ",";

// Check if date is sold out

var day_sold = day_sel[variation].info.sold;

//Add variation info to order form when availability exists

var tBody = document.getElementById("ticket-selected");

if ( day_sold == "sold_out" ) {
	
newRow = tBody.insertRow(-1);
td1 = newRow.insertCell(-1);
td1.setAttribute("id", "ticket-title");
td1.innerHTML="<strong>SOLD OUT</strong>";

} else {

newRow = tBody.insertRow(-1);

//Variation title

td1 = newRow.insertCell(-1);
td1.setAttribute("id" ,"ticket-title");
td1.innerHTML = this.variations[variation].type_title ;


//Quantity form fields

td2 = newRow.insertCell(-1);
td2.setAttribute("id", "highlight");
td2.setAttribute("align", "center");
td2.innerHTML = '<input id="amount_' + variation + '" name="amount_' + variation + '" type="text" value="" maxlength="3" style="width:20px;" onkeyup="mySelector.adjustTotal();"  />';


//Variation price form fields

	if ( this.variations[variation].free_entry ) {
		
	var price = 0;
	var user_price = "FREE";
	
	} else {
		
	var user_price = "&#36;" + this.variations[variation].price;
	var price = this.variations[variation].price;
	
	}

td3 = newRow.insertCell(-1);
td3.setAttribute("align", "right");
td3.innerHTML = user_price + '<input id="price_' + variation + '" type="hidden" value="' + price + '" />';

}

}

//Highlight selected date
dayElement.className = "dpTDselected";

//Deselect last chosen date
if (typeof this.lastSelected !== "undefined" && this.lastSelectedMonth == this.month ) {
	
document.getElementById(this.lastSelected).className = "dpDayAvailableTD";

}


//Set selected date and month as 'last selected'
this.lastSelected = dayElement.id;
this.lastSelectedMonth = this.month;


//Set hidden form values
document.getElementById('ticket_date').value = this.year + "-" + this.month + "-" + this.day;
document.getElementById("variations").value = variations_list.slice(0, -1);


//Rest the amount to pay total
this.adjustTotal();


}


//This extends the existing prototype
return INZU_dateSelector.prototype.selectDate.apply(this, arguments);


}


//------------------//




///Adjust order totals when user chooses a number of tickets


mySelector.adjustTotal = function adjustTotal(resetTotal){

var total = 0;
var amount_selected = 0;


if ( !resetTotal ) {

//Create total by each available variation for the selected date

	for ( var variation in this.variations ) {
		
		//Get amount selected for available variation
		amtSel = parseInt(document.getElementById('amount_' + variation).value) || 0;
		amount_selected += amtSel;
		
		price = parseFloat(document.getElementById('price_' + variation).value);
		console.log(price);
		
		if ( amtSel > 0) total += price * amtSel;
		
	}

}


total = Math.round( total * 100 ) / 100; 
total = total.toFixed(2);

document.getElementById('basketTotal').innerHTML = "&#36;" + total;

}




