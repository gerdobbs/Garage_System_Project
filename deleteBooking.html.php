<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To delete a Booking.
			This screen appears when the user clicks on "Cancel Booking" 
			on the "Bookings " tab on the menu.
			Todays bookings are shown as default.
			User can choose another date by selecting from a datepicker 
			and clicking "Get Bookings" button.
			If there are no bookings for the selected date it will display todays bookings.
-->
<?php
	//Start session in order to use session variables
	session_start();
	include "home.html.php";
	include 'garagedb.inc.php';
	date_default_timezone_set("UTC");
	//Get todays date and convert
	$bd = date("Y-m-d",strtotime(date("m/d/Y")));
	//Query both the boookings & customers table for todays date
	//Get booking details that are not marked for deletion
	$sql = "SELECT bookingID,date,time, name FROM Bookings inner join Customers on Bookings.customerID = Customers.customerID where date =  '$bd' 
		and Bookings.markForDeletion ='0' ORDER BY time";
	if(!$result = mysqli_query($con,$sql))
	{
		die('Error in querying db' . mysqli_error($con));
	}
	//Change date format for user interface
	$db = date("d-m-Y",strtotime(date("m/d/Y")));
?>
<html>
	<head>
		<script src="Gfunctions.js" type="text/javascript"></script>
	</head>
	<body>
		<div class='main'>
			<h1>Cancel Booking</h1>
			<!--Form to get booking date-->
			<form id='cancelBooking"  name='cancelBooking' action='deleteBooking1.html.php' autocomplete='off' method='POST'  >
				<label>Select Booking Date </label>
				<!--When date is selected send the date to function which will validate the date -->
				<input type="date" name="bookingdate" id="bookingdate" class='inputFieldK' onchange='bookingDate(this)' />
				<!--Send the details to "deleteBooking1.html.php which will show bookings for new date.-->
				<input type="submit" class="button" name="getbooking" id="getbooking"  value="Find Bookings"
						style='position:absolute;left:72%;top:100px;'disabled>
				<!--Hidden box for posting date-->
				<input type="hidden"  name="date" id="date"  class='inputFieldK' readonly value="<?php echo $bd;?>"/></br></br>
			</form>
			<!--Form to display bookings-->
			<form id='cancelBooking1"  name='cancelBooking1' action='deleteBooking2.html.php' autocomplete='off' method='POST' onsubmit='return validate()'  >
				<!--Display the date selected-->
				<label>Bookings :<?php echo  " ".$db;?></label>
				<table border="1" width='100%'>
				<tr><th>Time</th><th>Customer</th></tr>
				<?php
				//Display bookings in a table.
				while ($row = mysqli_fetch_array($result))
					{
						$id = $row['bookingID'];
						$fname = $row['name'];
						$time=$row['time'];
						//Query to check if job has commenced
						$sql = "SELECT JobID FROM Jobs WHERE bookingID = $id";
						if(!$result1 = mysqli_query($con,$sql))
							{
							die('Error in querying db' . mysqli_error($con));
							}
						$rowcount = mysqli_affected_rows($con);
						//Create String of id, firstname, lastname, date of birth
						$alltext = "$id#$fname#$rowcount#$time";
						echo "<tr><td id='time' style='width:150px;'>".$time."</td>
						<td id='table' onclick='change(\"" . $alltext . "\")' style='cursor:pointer;'>".$fname."</td></tr>";
					}	
					echo "</table>";
				?>
				<!--To post booking ID-->
				<input type="hidden"name="bookingID" id="bookingID"  >
				<!--Display selected name for deletion-->
				<p id="here">&nbsp;</p>
				<hr>
				<input type="submit" class="button" name="delete" id="delete" style="margin-bottom:0px;" value="Cancel Booking" disabled>
				<input type="reset" class="button" name="reset" id="reset"  value="Reset" onclick="location.href='deleteBooking.html.php'">
			</form>
		</div>
	</body>
</html>