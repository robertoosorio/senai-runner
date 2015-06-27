<?
	
	function getConn(){

		$host = "localhost";
		$user = "root";
		$pass = "root";
		$bd = "runners_runners";

		$conn = new mysqli($host, $user, $pass, $bd);
		// Check connection
		if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
		}
		return $conn;
	}

?>