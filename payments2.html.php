<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To update the Payments, Suppliers 
			and Invoices tables after cheque
			and letter sent
-->
<?php
	session_start();
	include "home.html.php";
	include 'garagedb.inc.php';
	date_default_timezone_set("UTC");
	$sql = "Select name, amountOwed from Supplier where supplierID = '$_SESSION[supplierID]'";
	if(!$result = mysqli_query($con,$sql))
	{
		die ('Error in querying database' . mysqli_error($con));
	}
	$row = mysqli_fetch_array($result);
	$name = $row['name'];
	$amount = $row['amountOwed'];
	$amount = $amount +  $_POST['amount'];
	//Update the amount owed to the supplier in the supplier table for relevant supplier
	$sql="UPDATE  Supplier SET amountOwed =0
		 where supplierID = '$_SESSION[supplierID]'";
	if(!mysqli_query($con,$sql))
	{
		die ("An error in the sql query: " . mysqli_error($con));
	}
	//Get todays date and format
	$date = date_create(date("Y/m/d"));
	$dbDate = date_format($date,"Y-m-d");
	//Update the paid flag in the invoive table for unpaid invoices relevant to the supplier	
	$sql="UPDATE  Invoice SET datePaid = '$dbDate'
		 where supplierID = '$_SESSION[supplierID]'";
	if(!mysqli_query($con,$sql))
	{
		die ("An error in the sql query: " . mysqli_error($con));
	}
	//Get the highest payment ID & add 1 to create next ID
	$sql = "SELECT MAX(paymentID) as nextID FROM Payments" ;	
	if(!$result = mysqli_query($con,$sql))
	{
		die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
	}
	$row = mysqli_fetch_assoc($result);
	$nextID = ++$row['nextID'];
	//Insert new payment into the Payments table
	$sql="INSERT into Payments (paymentID,amountPaid,supplierID,datePaid) 
		VALUES ($nextID,'$_SESSION[amountOwed]','$_SESSION[supplierID]','$dbDate')";
	if(!mysqli_query($con,$sql))
	{
		die ("An error in the sql query: " . mysqli_error($con));
	}
	session_unset(); 
	session_destroy();
?>
<html>
	
	<body>
		<div class="main">
		<h1>Invoice Paid</h1>
			<form action = "payments.html.php"	style="height:100px;" method="POST" >
				<h2>Supplier <?php echo $name?>'s Invoices Paid</h2>
				<input type="submit" name="submit" id="submit" value ="OK">
			</form>
		</div>
	</body>
</html>
<?php	
	mysqli_close($con);
?>
	
	