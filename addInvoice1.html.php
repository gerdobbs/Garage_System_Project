<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To add an Invoice.
			This screen appears when after the user has submitted the details
			to confirm if the invoice has been added sucessfullly.
-->
<?php
	//Start session in order to use session variables
	session_start();
	include 'garagedb.inc.php';
	include "home.html.php";
	date_default_timezone_set("UTC");
	//Query the supplier table to get the amount the supplier is owed before this invoice is added
	$sql = "Select amountOwed from Supplier where supplierID = '$_POST[supplierID]'";
	if(!$result = mysqli_query($con,$sql))
	{
		die ('Error in querying database' . mysqli_error($con));
	}
	$row = mysqli_fetch_array($result);
	$amount = $row['amountOwed'];
	//Add the amount on the invoice to the amount the supplier is owed up to now
	$amount = $amount +  $_POST['amount'];
	$date = date_create($_POST['date']);
	$dbDate = date_format($date,"Y-m-d");
	//SQL query to insert new Invoice
		$sql = "Insert into Invoice (amount,invoiceID,invoiceRefNum,InvDate,supplierID)
		VALUES ('$_POST[amount]','$_POST[ourRefNum]','$_POST[supplierRefNum]', '$dbDate','$_POST[supplierID]')";
		if(!mysqli_query($con,$sql))
		{
			die ("An error in the sql query: " . mysqli_error($con));
		}
		//SQL query to update the supplier table with the new amount owed
		$sql="UPDATE  Supplier SET amountOwed =$amount
				 where supplierID = $_POST[supplierID]";
			if(!mysqli_query($con,$sql))
		{
			die ("An error in the sql query: " . mysqli_error($con));
		}
	mysqli_close($con);
?>
<html>
	<body>
		<div class="main">
		<!--Inform user of successful addition of invoice with new Invoice ID-->
			<h1>Invoice Added Successfully</h1>
			<h2>Invoice <?php echo $_POST['ourRefNum']?> Added Successfully</h2>
			<!--Return to Original Add Invoice page-->
			<form action = "addInvoice.html.php"	 method="POST">
				<input type="submit" class="button" name="submit" id="submit"  value="OK" >
			</form>
		</div>
	</body>
</html>
			
		