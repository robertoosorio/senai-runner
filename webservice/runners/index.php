<?php
 
require_once('../Slim/Slim.php');
require_once('config.php');
 
\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app->response()->header('Content-Type', 'application/json;charset=utf-8');

//BUSCAR CORRIDAS
$app->get('/runs',function(){
	$conn = getConn();
	$r = $conn->query("SELECT * FROM corridas");
	$corridas = array();
	while($return = $r->fetch_assoc()) {
		$tratado = array();
		foreach ($return as $key => $value) {
			$tratado[$key] = htmlentities(trim($value));
		}
		$corridas[] = $tratado;
	}
	if(!empty($corridas)){
		$corridas = json_encode($corridas);
		echo "{corridas:".$corridas."}";
	}else{
		print_r(logMessage("204","Nenhuma corrida encontrada"));
		die();
	}	
	$conn->close();
});

//BUSCAR CORRIDA ESPECÍFICA
$app->get('/runs/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		$sql = "SELECT * FROM corridas WHERE id=".$id;
		$r = $conn->query($sql);        
		$corrida = $r->fetch_assoc();
		if(!empty($corrida))
			echo json_encode($corrida);
		else{
			print_r(logMessage("204","Nenhum corredor encontrado."));
			die();
		}
	}else {
		print_r(logMessage("203","Erro ao buscar corrida. O ID precisa ser numérico."));
		die();
	}
	$conn->close();
});

//CADASTRAR CORRIDA
$app->post('/runs',function(){
	
	if(empty($_POST)){//dados vindos no formato json
		$request = \Slim\Slim::getInstance()->request();
    	$d = json_decode($request->getBody());
    	$_POST = (array) $d;
    }

	$conn = getConn();
	$dados = cleanup($_POST,false);
	$keys = implode(",",array_keys($dados));
	$values = array();
	foreach ($dados as $key => $value) {
		if($key == 'data'){
			$value = dateInverter($value);
		}
		$values[] = "'".htmlentities(trim($value))."'";
	}
	$values = implode(",",$values);
	$sql = "INSERT INTO corridas(".$keys.") VALUES (".$values.")";
	$ok = $conn->query($sql);
	if(!$ok) {
		print_r(logMessage("503","Erro ao inserir corrida: " . $conn->connect_error));
		die();
	}else{
		print_r(logMessage("201","Corrida inserida com sucesso."));
		die();
	}
	$conn->close();
});

//ATUALIZAR CORRIDA
$app->put('/runs/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		if(isset($_POST['_METHOD'])) unset($_POST['_METHOD']);
		$dados = cleanup($_POST,false);
		$update = array();
		foreach ($dados as $key => $value) {
			if($key == 'data') $value = dateInverter($value);
			$update[] = $key."='".htmlentities(trim($value))."'";
		}
		$update = implode(",",$update);
		$sql = "UPDATE corridas SET ".$update." WHERE id=".$id;
		$ok = $conn->query($sql);			
		if(!$ok) {
			print_r(logMessage("503","Erro ao atualizar corrida: " . $conn->connect_error));
			die();
		}else{
			print_r(logMessage("202","Corrida atualizada com sucesso."));
			die();
		}
		$conn->close();
	}else{
		print_r(logMessage("203","Erro ao atualizar corrida. O ID precisa ser numérico."));
		die();
	}
});

//APAGAR CORRIDA Form html, campo oculto  <input type="hidden" name="_METHOD" value="DELETE"/>
$app->delete('/runs/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		$sql = "DELETE FROM corridas WHERE id = ".$id;
		$r = $conn->query($sql);
		if($r) {
			print_r(logMessage("200","Corrida deletada."));
			die();
		}else {
			print_r(logMessage("503","Erro ao deletar corrida."));
			die();
		}
		$conn->close();
	}else{
		print_r(logMessage("203","Erro ao deletar corrida. O ID precisa ser numérico."));
		die();
	}
});

######################## CORREDORES ########################

//CADASTRAR CORREDORES
$app->post('/runners',function(){
	if(empty($_POST)){//dados vindos no formato json
		$request = \Slim\Slim::getInstance()->request();
    	$d = json_decode($request->getBody());
    	$_POST = (array) $d;
    }

	$conn = getConn();
	$dados = cleanup($_POST,false);
	$keys = implode(",",array_keys($dados));
	$values = array();
	foreach ($dados as $key => $value) {
		if($key == 'data_nascimento'){
			$value = dateInverter($value);
		}
		$values[] = "'".htmlentities(trim($value))."'";
	}
	$values = implode(",",$values);
	$sql = "INSERT INTO corredor(".$keys.") VALUES (".$values.")";
	$ok = $conn->query($sql);
	if(!$ok) {
		print_r(logMessage("503","Erro ao inserir corredor: " . $conn->connect_error));
		die();
	}else{
		print_r(logMessage("201","Corredor inserido com sucesso."));
		die();
	}
	$conn->close();

});

//ATUALIZAR CORREDOR
$app->put('/runners/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		if(isset($_POST['_METHOD'])) unset($_POST['_METHOD']);
		$dados = cleanup($_POST,false);
		$update = array();
		foreach ($dados as $key => $value) {
			if($key == 'data_nascimento') $value = dateInverter($value);
			$update[] = $key."='".htmlentities(trim($value))."'";
		}
		$update = implode(",",$update);
		$sql = "UPDATE corredor SET ".$update." WHERE id=".$id;
		$ok = $conn->query($sql);			
		if(!$ok) {
			print_r(logMessage("503","Erro ao atualizar corredor: " . $conn->connect_error));
			die();
		}else{
			print_r(logMessage("202","Corredor atualizado com sucesso."));
			die();
		}
		$conn->close();
	}else{
		print_r(logMessage("203","Erro ao atualizar corredor. O ID precisa ser numérico."));
		die();
	}
});

//APAGAR CORREDOR
$app->delete('/runners/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		$sql = "DELETE FROM corredor WHERE id = ".$id;
		$r = $conn->query($sql);
		if($r) {
			print_r(logMessage("200","Corredor deletado."));
			die();
		}else {
			print_r(logMessage("503","Erro ao deletar corredor."));
			die();
		}
		$conn->close();
	}else{
		print_r(logMessage("203","Erro ao deletar corredor. O ID precisa ser numérico."));
		die();
	}
});

######################## INSCRIÇÕES ########################

//BUSCAR INSCRIÇÃO
$app->get('/runsEntry',function(){
	$conn = getConn();
	$r = $conn->query("SELECT * FROM inscricao");
	$inscricao = array();
	while($return = $r->fetch_assoc()) {
		$tratado = array();
		foreach ($return as $key => $value) {
			$tratado[$key] = htmlentities(trim($value));
		}
		$inscricao[] = $tratado;
	}
	if(!empty($inscricao)){
		$inscricao = json_encode($inscricao);
		echo "{inscricao:".$inscricao."}";
	}else{
		print_r(logMessage("204","Nenhuma inscrição encontrada"));
		die();
	}	
	$conn->close();
});

//BUSCAR INSCRIÇÃO ESPECÍFICA
$app->get('/runsEntry/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		$sql = "SELECT * FROM inscricao WHERE id=".$id;
		$r = $conn->query($sql);        
		$corrida = $r->fetch_assoc();
		if(!empty($corrida))
			echo json_encode($corrida);
		else{
			print_r(logMessage("204","Nenhuma inscrição encontrada."));
			die();
		}
	}else {
		print_r(logMessage("203","Erro ao buscar inscrição. O ID precisa ser numérico."));
		die();
	}
	$conn->close();
});

//CADASTRAR INSCRIÇÃO
$app->post('/runsEntry',function(){
	if(empty($_POST)){//dados vindos no formato json
		$request = \Slim\Slim::getInstance()->request();
    	$d = json_decode($request->getBody());
    	$_POST = (array) $d;
    }

	$conn = getConn();
	$dados = cleanup($_POST,false);
	$keys = implode(",",array_keys($dados));
	$values = array();
	foreach ($dados as $key => $value) {
		$values[] = "'".htmlentities(trim($value))."'";
	}
	$values = implode(",",$values);
	$sql = "INSERT INTO inscricao(".$keys.") VALUES (".$values.")";
	$ok = $conn->query($sql);
	if(!$ok) {
		print_r(logMessage("503","Erro ao inserir inscrição: " . $conn->connect_error));
		die();
	}else{
		print_r(logMessage("201","Inscrição inserida com sucesso."));
		die();
	}
	$conn->close();

});

//ATUALIZAR INSCRIÇÃO
$app->put('/runsEntry/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		if(isset($_POST['_METHOD'])) unset($_POST['_METHOD']);
		$dados = cleanup($_POST,false);
		$update = array();
		foreach ($dados as $key => $value) {
			$update[] = $key."='".htmlentities(trim($value))."'";
		}
		$update = implode(",",$update);
		$sql = "UPDATE inscricao SET ".$update." WHERE id=".$id;
		$ok = $conn->query($sql);			
		if(!$ok) {
			print_r(logMessage("503","Erro ao atualizar inscrição: " . $conn->connect_error));
			die();
		}else{
			print_r(logMessage("202","Inscrição atualizada com sucesso."));
			die();
		}
		$conn->close();
	}else{
		print_r(logMessage("203","Erro ao atualizar inscrição. O ID precisa ser numérico."));
		die();
	}
});

//APAGAR INSCRIÇÃO
$app->delete('/runsEntry/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		$sql = "DELETE FROM inscricao WHERE id = ".$id;
		$r = $conn->query($sql);
		if($r) {
			print_r(logMessage("200","Inscrição deletada."));
			die();
		}else {
			print_r(logMessage("503","Erro ao deletar inscrição."));
			die();
		}
		$conn->close();
	}else{
		print_r(logMessage("203","Erro ao deletar inscrição. O ID precisa ser numérico."));
		die();
	}
});

####################### MAIS DE UMA TABELA #######################

//BUSCAR CORREDORES DE UMA CORRIDA
$app->get('/runs/:id/runners',function($runId){
	if(is_numeric($runId)){
		$conn = getConn();
		$sql = "SELECT  inscricao.id as id_inscricao,
						inscricao.id_corredor as id_corredor,
						inscricao.id_corrida as id_corrida,
						inscricao.status as status_pagamento,corredor.* 
						FROM inscricao LEFT JOIN corredor ON corredor.id = inscricao.id_corredor WHERE inscricao.id_corrida = ".$runId;
		$r = $conn->query($sql);        
		$corredores = $r->fetch_assoc();
		if(!empty($corredores))
			echo json_encode($corredores);
		else{
			print_r(logMessage("204","Nenhum corredor encontrado."));
			die();
		}
	}else {
		print_r(logMessage("203","Erro ao buscar corredores. O ID precisa ser numérico."));
		die();
	}
	$conn->close();
});

/*
$app->get('/runs/:runId/runners/:id',function($runId,$id){});
$app->get('/runs/:runId/runsEntry',function($runId){});
$app->get('/runs/:runId/runsEntry/:id',function($runId,$id){});

$app->get('/runners/:runnerId/runsEntry',function($runnerId){});
$app->get('/runners/:runnerId/runs/:id',function($runnerId,$id){});
$app->get('/runners/:runnerId/runs',function($runnerId){});
$app->get('/runners',function(){});
$app->get('/runners/:id',function($id){});
$app->get('/runners/:runnerId/runsEntry/:id',function($runnerId,$id){});

$app->post('/runs/:runId/runsEntry',function($runId){});
$app->post('/runners/:runnerId/runsEntry',function($runnerId){});
$app->post('/runners/:runnerId/runs',function($runnerId){});

$app->put('/runs/:runId/runners/:id',function($runId,$id){});
$app->put('/runs/:runId/runsEntry/:id',function($runId,$id){});
$app->put('/runners/:runnerId/runs/:id',function($runnerId,$id){});
$app->put('/runners/:runnerId/runsEntry/:id',function($runnerId,$id){});

$app->delete('/runners/:runnerId/runs/:id',function($runnerId,$id){});
$app->delete('/runners/:runnerId/runsEntry/:id',function($runnerId,$id){});
$app->delete('/runs/:runId/runners/:id',function($runId,$id){});
$app->delete('/runs/:runId/runsEntry/:id',function($runId,$id){});
*/

$app->run();



#########################################################################################################
####################################        FUNÇÕES DIVERSAS        #####################################
#########################################################################################################
function dateInverter($data){
	if($data != ""){
		$explode = "-";
		$divisor = "/";
		if(strpos($data, "/") !== false){
			$explode = "/";
			$divisor = "-";
		}

		$data = explode($explode,$data);
		$data = $data[2].$divisor.$data[1].$divisor.$data[0];
	}
	return $data;	
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

function logMessage($codigo,$mensagem){
	$arr = array("code" => $codigo,
				"description" => htmlentities($mensagem));
	return json_encode($arr);
}


?>