<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To delete a Booking from the bookings table
			by setting mark for deletion to true.
			This screen will do the updates and tell the user if it was successful.
-->
<?php
	include "home.html.php";
	include 'garagedb.inc.php';
	date_default_timezone_set("UTC");
	//Update the bookings table by setting mark for deletion to true for the selected booking
	$sql = "UPDATE Bookings SET markForDeletion= '1' WHERE bookingID = '$_POST[bookingID]'";
		if(!$result = mysqli_query($con,$sql))
			{
				die('Error in querying db' . mysqli_error($con));
			}
?>
<html>
	<body>
		<div class="main">
			<h1>Booking Canceled<//h1>
			<h2>Booking ID 
				<?php echo $_POST['bookingID']?>
					Canceled Successfully.
			</h2>
			<form action="deleteBooking.html.php"	 method="POST">
				<!--Return to first Cancel Booking screen.-->
				<input type="submit" class="button" name="submit" id="submit"  value="OK" >
			</form>
		</div>
	</body>
<html>