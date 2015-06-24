<?php

require_once('../Slim/Slim.php');
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->contentType('text/html; charset=utf-8');
$app->response()->header('Content-Type', 'application/json;charset=utf-8');
$app->get('/', function () {
	echo "SlimProdutos";
});

$app->get('/corridas','getCorridas');
$app->post('/corrida','addCorrida');
$app->get('/corrida/:id','getCorrida');

//<input type="hidden" name="_METHOD" value="PUT"/>
$app->put('/corrida/:id', 'updateRun');

//<input type="hidden" name="_METHOD" value="DELETE"/>
$app->delete('/corrida/:id', 'deleteRun');

$app->run();

function inverterData($data){
	$explode = "-";
	$divisor = "/";
	if(strpos($data, "/") !== false){
		$explode = "/";
		$divisor = "-";
	}

	$data = explode($explode,$data);
	return $data[2].$divisor.$data[1].$divisor.$data[0];
}

function cleanup($data, $write=false) {
	if (is_array($data)) {
		foreach ($data as $key => $value) {
			$data[$key] = cleanup_lvl2($value, $write);
		}
	} else {
		$data = cleanup_lvl2($data, $write);
	}
	return $data;
}

function cleanup_lvl2($data, $write=false) {
	if (isset($data)) {
		$data = stripslashes($data);
		if ($write) {
			$data = mysql_real_escape_string($data);
		}
	}
	return $data;
}	

function getConn(){
	$conn = new mysqli('localhost', 'root', 'root', "runners");
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	} 
	return $conn;
}

function getCorridas(){
	$conn = getConn();

	$r = $conn->query("SELECT * FROM corridas");
	
	$corridas = array();
	while($return = $r->fetch_assoc()) {
		$tratado = array();
		foreach ($return as $key => $value) {
			$tratado[$key] = htmlentities($value);
		}
		$corridas[] = $tratado;
	}

	$corridas = json_encode($corridas);
	echo "{corridas:".json_encode($corridas)."}";
}


function addCorrida(){
	$conn = getConn();

	$dados = cleanup($_POST,false);
	
	$keys = implode(",",array_keys($dados));
	$values = array();
	foreach ($dados as $key => $value) {
		if($key == 'data'){
			$value = inverterData($value);
		}
		$values[] = "'".htmlentities($value)."'";
	}
	$values = implode(",",$values);

	$sql = "INSERT INTO corridas(".$keys.") VALUES (".$values.")";
	
	$ok = $conn->query($sql);
	
	if(!$ok){
		die("Erro ao inserir corrida: " . $conn->connect_error);
	}else{
		die("Corrida inserida com sucesso.");
	}

}

function getCorrida($id){

	if(is_numeric($id)){
		$conn = getConn();

		$sql = "SELECT * FROM corridas WHERE id=".$id;
		$r = $conn->query($sql);
		
		$corrida = $r->fetch_assoc();
		echo json_encode($corrida);

	}else{
		die("Erro ao buscar corrida. O ID precisa ser numérico.");
	}

}

function updateRun($id){
	$conn = getConn();
	if(is_numeric($id)){				
		$dados = cleanup($_POST,false);			
		$keys = implode(",",array_keys($dados));
		$values = array();
		foreach ($dados as $key => $value) {
			if($key == 'data'){
				$value = inverterData($value);
			}
			$values[] = $key."='".htmlentities($value)."'";
		}
		$values = implode(",",$values);

		print_r($values);die("PUT");

		$sql = "UPDATE corridas SET ".$update." WHERE id=".$id;
		$ok = $conn->query($sql);			
		if(!$ok){
			die("Erro ao inserir corrida: " . $conn->connect_error);
		}else{
			die("Corrida inserida com sucesso.");
		}

	}else{
		die("Erro ao buscar corrida. O ID precisa ser numérico.");
	}
}

function deleteRun($id){
	$conn = getConn();
	if(is_numeric($id)){
		$sql = "DELETE FROM corridas WHERE id = ".$id;
		$r = $conn->query($sql);
		if($r){
			die("Corrida deletada.");
		}else{
			die("Erro ao deletar corrida.");
		}
	}else{
		die("Erro ao buscar corrida. O ID precisa ser numérico.");
	}
}