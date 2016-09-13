<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To select the Supplier whos
			outstanding invoices are to
			to be paid.
-->
<?php
	session_start();
	include "home.html.php";
	include 'garagedb.inc.php';
	date_default_timezone_set("UTC");
	//SQL query to get supplier details for all suppliers who have not been marked for deletion
	$sql = "SELECT supplierID,name, address FROM Supplier WHERE markForDeletion=0 order by name";
		if(!$result = mysqli_query($con,$sql))
		{
			die('Error in querying db' . mysqli_error($con));
		}
?>
<html>
	<head> 
		<script>
			//Function to get the address of the supplier entered
			//Address is then entered into address field in the form
			function getAddress()
			{
				var sel = document.getElementById("supplierselect");
				var result;
				result = sel.options[sel.selectedIndex].value;
				var personDetails = result.split('#');
				document.getElementById("addressselect").value = personDetails[2];
				document.getElementById("supplierID").value = personDetails[0];
				document.getElementById("hiddenname").value = personDetails[1];
				document.getElementById("hiddenaddress").value = personDetails[2];
				document.getElementById("submit").disabled = false;
			}
		</script>
	</head>
	<body>
		<!--Form to select a supplier whos invoices are to be paid-->
		<div class="main">
			<h1>Add Payment</h1>
			<form id='addpayments'  name='addpayments' action='payments1.html.php' autocomplete="off" method='POST' >
				<!--Select Supplier from list-->
				<label>Supplier's Name </label>
				<select  required name='supplierselect' class="inputFieldK" id='supplierselect' style ='background-image:url(img/icons/User.png);width:230px;'
					placeholder="first name"  title='Select a supplier from the list' onchange='getAddress()'>
					<!--Create Array with details from query-->
					<?php
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
				</select></br></br>
				<label>Supplier's Address</label> 
				<!--Area where adress corresponding to selected Supplier-->
				<textarea rows="4"  form="addpayments" class="inputFieldR" name='addressselect' 
					id='addressselect' readonly placeholder='Address'>
					</textarea></br></br></br></br>
				<!--Hidden Boxes used to store name and adress which can then be posted-
					Populated from getAddress method-->
				<hr></br>
				<!--Hidden fields to post details-->
				<input type="hidden" name="hiddenname" id="hiddenname" >
				<input type="hidden" name="hiddenaddress" id="hiddenaddress" >
				<input type='hidden'  name='supplierID' id='supplierID' ></br>
				<input type="submit" style="margin-bottom:0px;" name="submit" id="submit"  disabled value="Get Invoices" >
			</form>
		</div>
	 </body>
</html>
