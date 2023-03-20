<?php
// Login details (please adjust according to your details)
$servername = "localhost"; // "selene.hud.ac.uk";
$username = "u2253319"; // "U1234567"
$password = "MA30nov02ma";  // By default, no password for XAMPP. Alternatively,
                 // password for Selene (as provided by IT)
$dbname = "u2253319"; // "U1234567"

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
