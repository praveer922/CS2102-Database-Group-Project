<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=amos0907")
    or die('Could not connect: ' . pg_last_error());    
?>

<?php

	if(isset($_GET['user'])) {
		echo "<h1>".$_GET['user']."'s received bids<hr>";

		$query = "SELECT petownerid, fromDate, toDate, price FROM Bids WHERE caretakerid='".$_GET['user']."'";

		$result = pg_query($query) or die('Query failed: ' . pg_last_error());

		echo "<table border=\"1\" >
			    <col width=\"25%\">
			    <col width=\"25%\">
			    <col width=\"20%\">
			    <col width=\"25%\">
			    <tr>
			    <th>Pet Owner</th>
			    <th>From</th>
			    <th>To</th>
			    <th>Price</th>
			    </tr>";

		while ($row = pg_fetch_row($result)){
		      echo "<tr>";
		      echo "<td>" . $row[0] . "</td>";
		      echo "<td>" . $row[1] . "</td>";
		      echo "<td>" . $row[2] . "</td>";
		      echo "<td>$" . $row[3] . "</td>";
		      echo "</tr>";
		    }
		echo "</table>";
		    
		pg_free_result($result);	    
	} 

?>