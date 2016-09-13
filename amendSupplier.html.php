<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose: To amend a suppliers details.
-->
<?php
	//Include the home page and connection to database
	include "home.html.php";
	include 'garagedb.inc.php';
?>
<html>
	<head> 
		<script>
		//Confirm that you are sure you wish to proceed
		function confirmCheck()
			{
				var response;
				response = confirm("Are you sure you want to amend this supplier?");
				if(response)
				{
					//Enable the fields
					document.getElementById("suppliername").disabled = false;
					document.getElementById("addressselect").disabled = false;
					document.getElementById("supplierID").disabled = false;
					document.getElementById("supplierphone").disabled = false;
					document.getElementById("supplierEmail").disabled = false;
					document.getElementById("supplierWebsite").disabled = false;
					return true;
				}
				else
				{
					//get the address of the supplier entered
					getAddress();
					//Changr the amend/view button
					amendViewButton();
					//Enable submit button
					document.getElementById("submit").disabled = true;
					return false;
				}
			}
			//Function to get the address of the supplier entered
			//Address is then entered into address field in the form
			function getAddress()
			{
				//Get Suppliers details & put into an array
				var sel = document.getElementById("supplierselect");
				var result;
				result = sel.options[sel.selectedIndex].value;
				var personDetails = result.split('#');
				//Print out supplier details into the appropriate boxes
				document.getElementById("addressselect").value = personDetails[2];
				document.getElementById("suppliername").value = personDetails[1];
				document.getElementById("supplierID").value = personDetails[0];
				document.getElementById("supplierphone").value = personDetails[4];
				document.getElementById("supplierEmail").value = personDetails[3];
				document.getElementById("supplierWebsite").value = personDetails[5];
				//Enable the submit button and amend button when supplier has been selected
				document.getElementById("amend").disabled=false;
				document.getElementById("submit").disabled=false;
			}
			//Function to change the amend button
			//Will enable or disable fields depending on value of button
			function amendViewButton()
			{
				if(document.getElementById("amend").value == "Amend")
				{
					document.getElementById("suppliername").disabled = false;
					document.getElementById("addressselect").disabled = false;
					document.getElementById("supplierphone").disabled = false;
					document.getElementById("supplierEmail").disabled = false;
					document.getElementById("supplierWebsite").disabled = false;
					document.getElementById("amend").value ="View";
					document.getElementById("suppliername").focus();
					document.getElementById("submit").disabled = false;
				}
				else
				{
					document.getElementById("suppliername").disabled = true;
					document.getElementById("addressselect").disabled = true;
					document.getElementById("supplierphone").disabled = true;
					document.getElementById("supplierEmail").disabled = true;
					document.getElementById("supplierWebsite").disabled = true;
					document.getElementById("amend").value ="Amend";
					document.getElementById("submit").disabled = true;
				}
			}
			//Function to disable the submit and amend buttons when reset is clicked
			function disableAmend()
			{
				document.getElementById("amend").disabled = true;
				document.getElementById("submit").disabled = true;
			}
			</script>
	</head>	
	<body>
		<div class="main">
			<h1>Amend/View Suppliers</h1>
			<!--Form to display Supplier details-->
			<form id='amendsupplier'  name='amendsupplier' id="amendsupplier" action='amendSupplier1.html.php' autocomplete="off"
					method='POST' onsubmit ="return confirmCheck()">
				<!--Select Supplier from list-->
				<label>Select Supplier </label>	
				<select   name='supplierselect' class='inputFieldK' id='supplierselect' 
							required title='Select a supplier from list'   placeholder='Select a Supplier from list' 
							style="background-image:url(img/icons/User.png); width:230px;" onchange='getAddress()'>
					<?php
						$sql = "SELECT * FROM Supplier where markForDeletion=0 ORDER by name";
						if(!$result = mysqli_query($con,$sql))
						{
							die('Error in querying db' . mysqli_error($con));
						}
						//Populate the Supplier list box-->
						while ($row = mysqli_fetch_array($result))
						{
							$id = $row['supplierID'];
							$fname = $row['name'];
							$address = $row['address'];
							$email= $row['email'];
							$phone = $row['phone'];
							$website = $row['webSite'];
							//Create String of id, firstname, lastname, date of birth
							$alltext = "$id#$fname#$address#$email#$phone#$website ";
							// value in each option is this string but just firstname & lastname displayed
							echo "<option value = '$alltext'>$fname </option>";
						}
						mysqli_close($con);
					?>
				</select></br></br>
				<label for='supplierID'>Supplier's ID </label>
				<input type='text' class="inputFieldR" name='supplierID' id='supplierID' disabled ></br></br>
				<label for='suppliername'>Supplier's Name </label>
				<input type="text"   name='suppliername' class='inputFieldK' id='suppliername' 
							style="background-image:url(img/icons/User.png);" placeholder='Enter Suppliers Name'  disabled ></br></br>
							 
				<label for='addressselect'>Supplier's Address</label> 
				<textarea rows="4"  form="amendsupplier" class="inputFieldK" name='addressselect' 
						  placeholder="Address" id='addressselect' disabled required
						  style="background-image:url(img/icons/home.png); "></textarea></br></br>
				</br></br>
				<label for='supplierphone'>Supplier' Phone </label>
				<input type='tel' class="inputFieldK" name='supplierphone' id='supplierphone' 
						 style="background-image:url(img/icons/phone.png);" placeholder=" Supplier Phone" disabled
						 pattern="[0-9 ()-]*" title="Use only numbers,(),-,commas or spaces" required></br></br>
				<label for='supplierWebsite'>Supplier's Website</label>
				<input type='text' class="inputFieldK requiredK" name='supplierWebsite' id='supplierWebsite' disabled
						 style="background-image:url(img/icons/email.png);" placeholder=" Supplier Website" required ></br></br>
				<label for='supplierEmail'>Supplier's Email </label>
				<input type='text' class="inputFieldK requiredK" name='supplierEmail' id='supplierEmail' 
						pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" title="There must be a '@' and a '.' in the email"disabled
						placeholder=" SupplierEmail" required  style="background-image:url(img/icons/email.png);"></br></br>
				<hr>
				<input type="submit" disabled class="button" name="submit" id="submit"  value="Submit" >
				<!--Amend buutton calls function when clicked-->
				<input type="button" class="amend" name="amend" id="amend" disabled style='position:relative;left:2%;' value="Amend" onclick="amendViewButton()" >
				<input type="reset" class="button" name="reset" id="reset"  value="Reset" onclick="disableAmend()">
			</form>
		</div>
	</body>
</html>