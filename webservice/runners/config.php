<?
	
	function getConn(){

		$host = "localhost";
		$user = "root";//runners_master
		$pass = "root";//7MahD5=N@em
		$bd = "runners_runners";

		$conn = new mysqli($host, $user, $pass, $bd);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}

?>