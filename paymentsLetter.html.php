<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To Print a letter to a supplier
			detailing the invoices being paid
			 and the total amount. 
-->
<?php
	session_start();
	include "home.html.php";
	include 'garagedb.inc.php';
	date_default_timezone_set("UTC");
	$date = date_create(date("Y/m/d"));
	$dbDate = date_format($date,"d/m/Y");
	//Make Query for entries with the supplier ID & also for unpaid Invoices
	//$sql = "SELECT invoiceID,amount FROM Invoice where supplierID = '$_SESSION[supplierID]' and datePaid = '$dbDate'";
	$sql = "SELECT invoiceID,invoiceRefNum,amount FROM Invoice where supplierID = '$_SESSION[supplierID]'and datePaid is null 
			and markForDeletion=0 ORDER BY invoiceID";
		if(!$result = mysqli_query($con,$sql))
		{
			die('Error in querying db' . mysqli_error($con));
		}
?>
<html>
	<head>
		<link href="letter.css" rel="stylesheet" type="text/css">
		<link href="payments1.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div class="main">
		<h1>Payments Letter</h1>
			<!--Letter to be Sent to Supplier-->
			<div id="letter">
				<form id='letterprint'  name='letter' action='payments2.html.php' autocomplete="off" method='POST' >
					<p id="headers">The Garage,</br>High Street,</br>Carlow.</br><?php echo $dbDate;?></p>
					<p id="SupplierName"></br></br></br>
						<!--Get the name and address from Form & print details-->
						<?php echo $_SESSION['suppliername']."<br>".$_SESSION['supplieraddress']."<br>" ."<br>"; 
						?>
					</p>
					Enclosed please find Cheque for
						<?php
							echo $_SESSION['amountOwed']
						?>
					in payment of the following invoices.</br>
					<label class='label label2' >Supplier Invoice Ref</label>
					<label class='inputFieldK label' >Amount</label>
					<ul>
						<?php
							//Initialize total of invoices to 0
							$total = 0;
							while ($row = mysqli_fetch_array($result))
							{
								$id = $row['invoiceRefNum'];
								$amountOwed = $row['amount'];
								//Add amount on each invoice to total
								$total = $total + $amountOwed;
								//Session variable to beused on next form
								$_SESSION['amountOwed'] = $total;
								//Create String of id, firstname, lastname, date of birth
								$fulltext = "$id,$amountOwed";
								// value in each option is this string but just ID & amount displayed
								echo "<li value = '$fulltext'  ><label>$id</label>";
								echo "<label class='inputFieldK'>$amountOwed</label></li>";
							}
							echo "</br><label class='label' >Total Amount Due</label><label class='inputFieldK label' >Total Amount Paid</label></br>";
							echo "<label>$total</label><label class='inputFieldK' >$total</label>";
							mysqli_close($con);
						?>
					<p id="letter">Yours Sincerely,<br>
						Ger Dobbs<br>
						Manager
					</p>
					</ul></br></br>
					<input type="submit" name="submit" id="submit" value ="Print">
				</form>	
			</div>
		</div>
	</body>
</html>