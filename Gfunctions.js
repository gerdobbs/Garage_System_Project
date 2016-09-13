/*Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: Javascript functions used. 
			
*/
//Ensure Booking date for cancellation must not be before todays date
	function bookingDate(date)
	{
		//Todays date
		var today = new Date();
		//Date on Invoice
		var bookingDay = date.value;
		var today1 = Date.parse(today);
		var bookingDay1 = Date.parse(bookingDay);
		//compare todays date to invoice date
		//Invoice date must not be before todays date
		document.getElementById("getbooking").disabled = false;
		//Is booking before todays date
		if(bookingDay1<today1)
		{
			//Custom error message
			bookingdate.setCustomValidity("Booking Date cannot be before todays date");
		}
		else
		{
			//Clear custom error message
			bookingdate.setCustomValidity("");
			//If selected date is valid, put date into hidden box for posting
			document.getElementById("date").value =  document.getElementById("bookingdate").value;
		}
	}
//Function called when booking selected for deletion
	function change(value)
	{
		//Enable the "Delete" button
		document.getElementById("delete").disabled=false;
		//Put parameter of ID, name and time into an array
		var personDetails = value.split('#');
		//IF rowcount in query is >0 then the booking has commenced
		if(personDetails[2] >0)
		{
			document.getElementById("here").innerHTML= "Cancel Booking for " +personDetails[1] + " at " + personDetails[3]+" ?";
			alert("THIS BOOKING HAS ALREADY COMMENCED!");
		}
			document.getElementById("bookingID").value= personDetails[0];
			document.getElementById("here").innerHTML= "Cancel Booking for " +personDetails[1] + " at " + personDetails[3]+" ?";
	}
//Confirm deletion before submission
	function validate()
	{
		var confirmation = confirm('Are you sure you want to cancel this booking?');
		if(confirmation)
		{
			return true ;
		}
		else{
			return false ;
		}
	}
			
			
			
			
			