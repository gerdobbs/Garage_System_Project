<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To amend a suppliers details.
-->
<html>
	<body>
<?php
	//Include the home page and connection to database
	include "home.html.php";
	include 'garagedb.inc.php';
	date_default_timezone_set("UTC");
	//Update the Supplier table with the amended details
	$sql = "UPDATE Supplier SET name = '$_POST[suppliername]', address = '$_POST[addressselect]',
			email = '$_POST[supplierEmail]', phone = '$_POST[supplierphone]',webSite = '$_POST[supplierWebsite]' WHERE supplierID = '$_POST[supplierID]'";
	if(!mysqli_query($con,$sql))
	{
		echo "Error" . mysqli_error();
	}
	else
	{
		echo "<div class='main'>";
		//If there was data changed
		if(mysqli_affected_rows($con) != 0)	
		{
			echo "<h1>Supplier Amended</h1>";
			echo "<h2>Supplier  ".$_POST['suppliername']." record(s) updated</h2><br>";
		}
		else
		{
			echo "<h2>No records were changed</h2>";
		}
	}
	mysqli_close($con);
?>
			<form action="amendSupplier.html.php"	 method="POST">
				<input type="submit" class="button" name="submit" id="submit"  value="OK" >
			</form>
		</div>
	</body>
</html>