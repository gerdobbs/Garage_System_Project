<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To delete a Booking. 
			This screen appears when the user selects a new date for bookings
			User selects booking from list of bookings
			for a previously selected date.
-->
<?php
	//Start session in order to use session variables
	session_start();
	include "home.html.php";
	include 'garagedb.inc.php';
	date_default_timezone_set("UTC");
	//Query both the boookings & customers table
	//Get booking details that are not marked for deletion
	$sql = "SELECT bookingID,date,time, name FROM Bookings inner join Customers on Bookings.customerID = Customers.customerID where date =  '$_POST[date]' 
		and Bookings.markForDeletion ='0' ORDER BY time";
		if(!$result = mysqli_query($con,$sql))
		{
			die('Error in querying db' . mysqli_error($con));
		}
		//If there are no bookings for the selected date then return to original page
		$rowcount = mysqli_affected_rows($con);
			if($rowcount==0)
			{
				header("Location: /deleteBooking.html.php");
				exit;
			}
	//Change date format for selected date user interface	
	$db = $_POST['date'];
	$db = date("d-m-Y",strtotime($db));
?>
<html>
	<head>
		<script src="Gfunctions.js" type="text/javascript"></script>
	</head>
	<body>
		<div class='main'>
			<h1>Cancel Booking</h1>
			<form id='cancelBooking"  name='cancelBooking' action='deleteBooking1.html.php' autocomplete='off' method='POST'  >
				<label>Select Booking Date </label>
				<input type="date" name="bookingdate" id="bookingdate" class='inputFieldK' disabled onchange='bookingDate(this)' />
				<input type="submit" class="button" name="submit" id="submit"  value="Get New Date" 
						style='position:absolute;left:71%;top:100px;' onclick="location.href='deleteBooking.html.php'">
				<input type="hidden"  name="date" id="date"  class='inputFieldK' readonly value="<?php echo $bd;?>"/></br></br>
			</form>
			<!--Form to display bookings-->
			<form id='deleteBooking"  name='deleteBooking' action='deleteBooking2.html.php' autocomplete='off' method='POST' onsubmit='return validate()'  >
				<label>Bookings:<?php echo " ".  $db ;?></label>
				<table border="1" width='100%'>
				<tr><th>Time</th><th>Customer </th></tr>
				<?php
					while ($row = mysqli_fetch_array($result))
					{
						$id = $row['bookingID'];
						$fname = $row['name'];
						$time=$row['time'];
						$_SESSION["ID"]= $id;
						//Query to check if job has commenced
						$sql = "SELECT JobID FROM Jobs WHERE bookingID = $id";
						if(!$result1 = mysqli_query($con,$sql))
							{
							die('Error in querying db' . mysqli_error($con));
							}
						$rowcount = mysqli_affected_rows($con);
						//Create String of id, name and if booking has commenced
						$alltext = "$id#$fname#$rowcount#$time";
						echo "<tr><td id='time' style='width:150px;'>".$time."</td>
						<td id='table' onclick='change(\"" . $alltext . "\")' style='cursor:pointer;'>".$fname."</td></tr>";
						//<td onclick ='getName(\"" . $allText . "\")' style='cursor:pointer;' width='45%'>".$name."</td>
						//<td onclick ='getName(\"" . $allText . "\")' style='cursor:pointer;' width='45%'>".$address."</td>
					}	
					echo "</table>";
				?>
				<!--To post booking ID-->
				<input type="hidden"name="bookingID" id="bookingID"  >
				<!--Display selected name for deletion-->
				<p id="here">&nbsp;</p>
				<hr>
				<input type="submit" class="button" name="delete" id="delete"  value="Cancel Booking" style="margin-bottom:0px;" disabled>
				<input type="reset" class="button" name="reset" id="reset"  value="Reset" onclick="location.href='deleteBooking.html.php'">
			</form>
		</div>
	</body>
</html>