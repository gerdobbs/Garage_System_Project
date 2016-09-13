<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To add an Invoice.
			This screen appears when the user clicks on "Add Invoice" 
			on the "Accounts " tab on the menu.
			The user selects a supplier from a dropdown list.
			The address of the selected supplier will then appear
			in order for the user to decide if the right supplier has been selected.
-->
<?php
	include "home.html.php";
	include  'garagedb.inc.php';
	date_default_timezone_set("UTC");
	//Query the Supplier table for details of suppliers who are not marked for deletion
	$sql = "SELECT supplierID,name, address FROM Supplier WHERE markForDeletion = 0 order by name";
	if(!$result = mysqli_query($con,$sql))
	{
		die('Error in querying db' . mysqli_error($con));
	}
?>
<html>
	<head> 
		<script src="Gfunctions.js" type="text/javascript"></script>
		<script>
			//Function to Ask user if they are sure they want to submit using confirm box
			//Returns true or false to form
			function validate()
			{
				var confirmation = confirm('Are you sure you want to add this invoice?');
				if(confirmation)
				{
					return true ;
				}
				else{
					return false ;
				}
			}
			//Function to get the address of the supplier entered
			//Address is then entered into address field in the form
			function getAddress()
			{
				var sel = document.getElementById("supplierselect");
				var result;
				result = sel.options[sel.selectedIndex].value;
				var personDetails = result.split('#');
				document.getElementById("supplierID").value = personDetails[0];
				document.getElementById("addressselect").value = personDetails[2];
				document.getElementById("supplierRefNum").focus();
			}
			//Function to validate the invoice date
			//Date cannot be after todays date
			function invoiceDate(date)
			{
				//Todays date
				var today = new Date();
				//Date on Invoice
				var invoiceDay = date.value;
				var today1 = Date.parse(today);
				var invoiceDay1 = Date.parse(invoiceDay);
				//compare todays date to invoice date
				//Invoice date must not be before todays date
				if(invoiceDay1>today1)
				{
					//Custom error message
					date.setCustomValidity("Invoice Date cannot be after todays date");
				}
				else{
					//Clear custom error message
					date.setCustomValidity("");
				}
			}
		</script>
	</head>	
	<body>
		<div class='main'>
			<h1>Add Invoice</h1>
			<form id='addinvoice'  name='addinvoice' action='addInvoice1.html.php' autocomplete='off' method='POST' onsubmit='return validate()'>
				<!--Select Supplier from list-->
				<label>Supplier's Name </label>
				<select   required name='supplierselect' class='inputFieldK' id='supplierselect' style="background-image:url(img/icons/User.png);width:230px;"
						  placeholder='first name'  onchange='getAddress()'>
					<?php
						//Populate dropbox with supplier details
						while ($row = mysqli_fetch_array($result))
						{
							$id = $row['supplierID'];
							$fname = $row['name'];
							$address = $row['address'];
							//Create String of id, firstname, lastname, date of birth
							$alltext = "$id#$fname#$address";
							// value in each option is this string but just firstname & lastname displayed
							echo "<option value = '$alltext'>$fname </option>";
						}
					?>
				</select>
				<!--Hidden field will hold supplier id for sending to next screen-->
				<input type='hidden' class="inputFieldR" name='supplierID' id='supplierID' readonly  
						></br></br>
				<label>Supplier's Address</label> 
				<textarea rows="4"  form="addinvoice" class="inputFieldR" name='addressselect' 
						  id='addressselect' readonly > </textarea></br></br></br></br>
				<!-- Get the highest Invoice Id from the table-->
				<input type='hidden' class="inputFieldK" name='ourRefNum'   readonly
					   value=
						"<?php $sql = "SELECT MAX(invoiceID) as nextID FROM Invoice" ;	
								if(!$result = mysqli_query($con,$sql))
								{
									die("An Error in the SQL Query:" .mysqli_error("Error") ) ;
								}
								$row = mysqli_fetch_assoc($result);
								//Add 1 to the id retrieved
								//This is the new Invoice ID-->
								$_SESSION['invoiceID'] = ++$row['nextID'];
								echo $_SESSION['invoiceID']
							?>">
				<!--Input Suppliers reference number, Invoice Date and Invoice amount-->
				<label for="supplierRefNum">Supplier's Reference Number </label>
				<input type='text' class="inputFieldK requiredK" name='supplierRefNum' id='supplierRefNum' style ='background-image:url(img/icons/ID.png);'
						placeholder="Supplier Invoice Ref. Num." title='Enter Number from Invoice'required ></br></br>
				<label>Date on Invoice</label>
				<input type='date' class="inputFieldK requiredK" style="background-image:url(img/icons/date.png);"
						name='date'  required onblur='invoiceDate(this)'
						></br></br>
				<label for="amount">Amount on Invoice</label>
				<input type='text' class="inputFieldK requiredK" name='amount' id='amount' placeholder="Enter amount on invoice"
						 pattern="[0-9. ]*" required title='Enter Amount using numbers or decimal point only'
						 style ='background-image:url(img/icons/ID.png);'>
				<br><hr>
				<input type="submit" class="button" name="submit" id="submit"  style="margin-bottom:0px; value="Submit" >
				<input type="reset" class="button" name="reset" id="reset"  value="Reset" >
			</form>
			<?php
				mysqli_close($con);
			?>
		</div>
	</body>
</html>
	
