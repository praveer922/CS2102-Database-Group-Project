<html>
<head> <title>Pets Paradise</title> </head>

<body>
<table>
<tr> <td colspan="2" style="background-color:#FFA500;">
<h1>Welcome to Pets Paradise - Singapore's No. 1 Pet Caring portal!</h1>
</td> </tr>

<?php
$dbconn = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=amos0907")
    or die('Could not connect: ' . pg_last_error());
?>

<tr>
<td style="background-color:#eeeeee;">
<form>
        Caretaker's name: <input type="text" name="name" id="name">
        Pet breed: <input type="text" name="breed" id="breed">
        Location: <input type="text" name="location" id="location">


        <input type="submit" name="formSubmit" value="Search" >
</form>
<?php

if(isset($_GET['formSubmit'])) 
{
    $query = "SELECT userid, name, email, description FROM USERS WHERE (name LIKE UPPER('%".$_GET['name']."%') AND UPPER(description) LIKE UPPER('%".$_GET['breed']."%') AND UPPER(address) LIKE UPPER('%".$_GET['location']."%')) AND (isA = 'caretaker' OR isA = 'both')";
    echo "<b>SQL:   </b>".$query."<br><br>";
    $result = pg_query($query) or die('Query failed: ' . pg_last_error());
    echo "<table border=\"1\" >
    <col width=\"15%\">
    <col width=\"15%\">
    <col width=\"15%\">
    <col width=\"55%\">
    <tr>
    <th>Username</th>
    <th>Name</th>
    <th>Email</th>
    <th>Description</th>
    </tr>";


    while ($row = pg_fetch_row($result)){
      echo "<tr>";
      echo "<td><a href=profile.php?user=" . $row[0] . ">".$row[0]."</a></td>";
      echo "<td>" . $row[1] . "</td>";
      echo "<td>" . $row[2] . "</td>";
        echo "<td>" . $row[3] . "</td>";
      echo "</tr>";
    }
    echo "</table>";
    
    pg_free_result($result);
}
?>

</td> </tr>
<?php
pg_close($dbconn);
?>
<tr>
<td colspan="2" style="background-color:#FFA500; text-align:center;"> Copyright &#169; CS2102
</td> </tr>
</table>


<p>No account? <a href="register.php">Register Now!</a>

</body>
</html>



