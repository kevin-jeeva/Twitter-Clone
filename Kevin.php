 <?php
$servername = "mynewlab.czlwvcnxx2l9.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "Lab2Kevin";
$dbname = "Demo";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";
echo "<br>";

$sql = "SELECT * FROM `students`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    echo "id: " . $row["ID"]. " - Name: " . $row["FirstName"]. " " . $row["LastName"]. "<br>";
  }
} else {
  echo "0 results";
}
$conn->close();

?> 
