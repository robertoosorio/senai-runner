<?php

//BUSCAR CORRIDAS
$app->get('/runs',function(){
	$conn = getConn();
	$r = $conn->query("SELECT * FROM corridas ORDER BY data DESC");
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
		logMessage("204","Nenhuma corrida encontrada");
		die();
	}	
	$conn->close();
});

//BUSCAR CORRIDAS ABERTAS
$app->get('/runs/open',function(){
	$conn = getConn();
	$r = $conn->query("SELECT * FROM corridas WHERE status='agendada' ORDER BY data DESC");
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
		logMessage("204","Nenhuma corrida encontrada");
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
			logMessage("204","Nenhuma corrida encontrada.");
			die();
		}
	}else {
		logMessage("203","Erro ao buscar corrida. O ID precisa ser numerico.");
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
		logMessage("503","Erro ao inserir corrida: " . $conn->connect_error);
		die();
	}else{
		logMessage("201","Corrida inserida com sucesso.");
		die();
	}
	$conn->close();
});

//ATUALIZAR CORRIDA
$app->put('/runs/:id',function($id){
	if(is_numeric($id)){
		if(empty($_POST)){//dados vindos no formato json
			$request = \Slim\Slim::getInstance()->request();
	    	$d = json_decode($request->getBody());
	    	$_POST = (array) $d;
	    }
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
			logMessage("503","Erro ao atualizar corrida: " . $conn->connect_error);
			die();
		}else{
			logMessage("202","Corrida atualizada com sucesso.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao atualizar corrida. O ID precisa ser numerico.");
		die();
	}
});

//APAGAR CORRIDA
$app->delete('/runs/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		$sql = "DELETE FROM corridas WHERE id = ".$id;
		$r = $conn->query($sql);
		if($r) {
			logMessage("200","Corrida deletada.");
			die();
		}else {
			logMessage("503","Erro ao deletar corrida.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao deletar corrida. O ID precisa ser numerico.");
		die();
	}
});

//BUSCAR INSCRICOES DE UMA CORRIDA
$app->get('/runs/:id/runsEntry',function($runId){
	if(is_numeric($runId)){
		$conn = getConn();
		$sql = "SELECT  inscricao.id as id_inscricao,
						inscricao.id_corredor as id_corredor,
						inscricao.id_corrida as id_corrida,
						inscricao.status as status_pagamento,
						corredor.* 
						FROM inscricao 
						LEFT JOIN corredor ON corredor.id = inscricao.id_corredor 
						WHERE inscricao.id_corrida = ".$runId;
		$r = $conn->query($sql);        
		$corredores = $r->fetch_assoc();
		if(!empty($corredores))
			echo json_encode($corredores);
		else{
			logMessage("204","Nenhum corredor encontrado.");
			die();
		}
	}else {
		logMessage("203","Erro ao buscar corredores. O ID precisa ser numerico.");
		die();
	}
	$conn->close();
});

