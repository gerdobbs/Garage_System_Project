<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To amend a suppliers details.paid
-->
<html>
	<head>
		<link href="payments1.css" rel="stylesheet" type="text/css">
		<script>
			//Function to reload the page once only
			//Code taken from following;
			//http://stackoverflow.com/questions/6985507/one-time-page-refresh-after-first-page-load
			(function()
			{
			//If data is stored in local browser
				if( window.localStorage )
				{
				 //Refresh the page before its visible to user
					if( !localStorage.getItem( 'firstLoad' ) )
					{
						localStorage[ 'firstLoad' ] = true;
						 window.location.reload();
					}  
					else
						localStorage.removeItem( 'firstLoad' );
				}
			})();
			//Function to Ask user if they are sure they want to submit using confirm box
			//Returns true or false to form
			function validate()
			{
				var confirmation = confirm('Are you sure you want to make this payment');
				if(confirmation)
				{
					return true ;
				}
				else
				{
					return false ;
				}
			}
		</script>
	</head>
	<body>
		<?php
			session_start();
			include "home.html.php";
			include 'garagedb.inc.php';
			//Make Query for entries with the supplier ID & also for unpaid Invoices
			$sql = "SELECT invoiceID,invoiceRefNum,amount FROM Invoice where supplierID = '$_SESSION[supplierID]'and datePaid is null 
					and markForDeletion=0 ORDER BY invoiceID";
			if(!$result = mysqli_query($con,$sql))
			{
				die('Error in querying db' . mysqli_error($con));
			}
			$_SESSION['supplierID']=$_POST['supplierID'];
			$_SESSION['suppliername']=$_POST['hiddenname'];
			$_SESSION['supplieraddress']=$_POST['hiddenaddress'];
			$rowcount = mysqli_affected_rows($con);
			//If there are invoices for the selected supplier the display details for each invoice
			if($rowcount>0)
			{
				echo "<div class='main'>";
				echo "<h1>Payments</h1>";
				echo "<form id='supplierinvoices'  name='supplierinvoices' action='paymentsLetter.html.php' autocomplete='off' method='POST'  onsubmit='return validate()'>";
					echo "<label>Supplier's Name</label>";
					echo "<label class='inputFieldK'>".$_POST['hiddenname']."</label>";
					echo "  "."</br></br>";
					echo "<label class='label label2' >Supplier Invoice Ref</label>";
					echo "<label class='inputFieldK label' >Amount</label>";
					echo 	"<ul id='letter'>";
					//Initialize total of invoices to 0
					$total = 0;
					while ($row = mysqli_fetch_array($result))
					{
						$id = $row['invoiceRefNum'];
						$amountOwed = $row['amount'];
						//Add amount on each invoice to total
						$total = $total + $amountOwed;
						//Session variable to be used on next form
						$_SESSION['amountOwed'] = $total;
						//Create String of id, firstname, lastname, date of birth
						$fulltext = "$id,$amountOwed";
						// value in each option is this string but just ID & amount displayed
						echo "<li class='lists'><label>$id</label>
							 <label class='inputFieldK'>$amountOwed</label></li>";
					}
					//Close connection to database
					mysqli_close($con);
					echo "</ul></br>";
					echo "<label class='label2'>Total Payment ". $total . "</label><hr>";
					echo "<input type='submit' name='submit' id='submit'style='margin-bottom:0px;' value ='Process Payment'>";
					//<!--Link to previous page when"Cancel" is pressed-->
					echo "<a href='payments.html.php'><input type='button' class='amend' name='submit' id='submit' value ='Cancel' ></a>";
			}
			//If there are no unpaid invoices for the selected supplier
			else 
			{
				echo "<div class='main'>";
				echo "<h1>Invoices</h1>";
				echo "<form id='supplierinvoices'  name='supplierinvoices' action='payments.html.php' autocomplete='off' method='POST' >";
					echo "<h2>No Invoices for ".$_SESSION['suppliername']."</h2>";
					echo 	"</br></br>";
					//<!--Link to previous page when"Cancel" is pressed-->
					echo "<input type='submit' name='submit' class='amend' id='submit' value ='Cancel' ></a>";
			}	
		?>		
			</ul>
		</form>
	</body>
</html>
				