<!--Created by Ger Dobbs
	Student Number: C00196843
	Date: March 2016
	Project: Garage
	Purpose:  To Present a Stock Status Report Ordered by Description.
-->
<html>
	<body>
		<?php
			include "home.html.php";
			include 'garagedb.inc.php';
			//Query to get the stock details from the Stock table and the stock supplier from the Supplier table
			$sql = "SELECT description,stockID, quantityInStock, name FROM Supplier 
					inner join Stock on Supplier.supplierID = Stock.supplierID where Stock.markForDeletion = 0 order by description";
			if(!$result = mysqli_query($con,$sql))
			{
				die('Error in querying db' . mysqli_error($con));
			}
			echo "<div class='main'><h1>Stock Status Report-By Description</h1>";
				echo "<form action='reportBysupplier.html.php' method='post'>";
					echo "<table  border='1' width='100%'>";
					echo "<tr><pre><th>Stock Description    </th><th>Stock Number    </th><th>Qty. in Stock    </th><th>Supplier's Name</th></pre></tr>";
					while ($row = mysqli_fetch_array($result))
					{
						echo "<tr ><td>".$row['description']."</td><td>".$row['stockID']."</td><td>".$row['quantityInStock']."</td><td>".$row['name']."</tr>";
					}
		?>
					</table>
					<hr></br>
					<form action=="reportBysupplier.html.php" method="POST">
					<!--By Description button disabled-->
			<input type="submit" style="margin-bottom:0px; name="description" id="description" value="By Description" disabled  > </a>
			<!--By Supplier button enabled-->
			<input type="Submit" name="supplier" id="supplier" value="By Supplier" style="position:absolute;left:75%;margin-bottom:0px;"></a>
		</div>
	</body>
</html>