<?php
session_start();

if(isset($_POST['name']) && isset($_SESSION['name']) && $_POST['name'] == $_SESSION['name'])
{
	//Create connection
	$servername = "localhost";
	$username = "protoj18_dbuser";
	$dbpassword = "Kobe08jpx";
	$dbname = "protoj18_RPGFF";
	$conn = new mysqli($servername, $username, $dbpassword, $dbname);

	//Check connection
	if ($conn->connect_error) 
	{
		$_SESSION["error"] = "Cannot connect to server.";
		die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "UPDATE players SET Email='', emailupdates='0' WHERE name='" . $_SESSION["name"] . "'";
	//Send query
	$result = $conn->query($sql);
	//Close connection
	$conn->close();
	
	if(isset($_SESSION['email']))
		$_SESSION['email'] = "";
	
	//Return to page
	header("location: editprofile.php");
	exit();
}
else
{
	//Return to page
	header("location: home.php");
	exit();
}
?>