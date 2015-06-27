<?php

//BUSCAR CORREDORES
$app->get('/runners',function(){
	$conn = getConn();
	$r = $conn->query("SELECT * FROM corredor ORDER BY nome");
	$corredor = array();
	while($return = $r->fetch_assoc()) {
		$tratado = array();
		foreach ($return as $key => $value) {
			$tratado[$key] = htmlentities(trim($value));
		}
		$corredor[] = $tratado;
	}
	if(!empty($corredor)){
		$corredor = json_encode($corredor);
		echo "{corredores:".$corredor."}";
	}else{
		logMessage("204","Nenhuma corrida encontrada");
		die();
	}	
	$conn->close();
});

//BUSCAR CORREDORES
$app->get('/runners/actives',function(){
	$conn = getConn();
	$r = $conn->query("SELECT * FROM corredor WHERE status='ativo' ORDER BY nome");
	$corredor = array();
	while($return = $r->fetch_assoc()) {
		$tratado = array();
		foreach ($return as $key => $value) {
			$tratado[$key] = htmlentities(trim($value));
		}
		$corredor[] = $tratado;
	}
	if(!empty($corredor)){
		$corredor = json_encode($corredor);
		echo "{corredores:".$corredor."}";
	}else{
		logMessage("204","Nenhuma corrida encontrada");
		die();
	}	
	$conn->close();
});

//BUSCAR CORREDOR ESPECÍFICO
$app->get('/runners/:id',function($id){
	if(is_numeric($id)){
		$conn = getConn();
		$sql = "SELECT * FROM corredor WHERE id=".$id;
		$r = $conn->query($sql);        
		$corredor = $r->fetch_assoc();
		if(!empty($corredor))
			echo json_encode($corredor);
		else{
			logMessage("204","Nenhum corredor encontrado.");
			die();
		}
	}else {
		logMessage("203","Erro ao buscar corredor. O ID precisa ser numerico.");
		die();
	}
	$conn->close();
});

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
		logMessage("503","Erro ao inserir corredor: " . $conn->connect_error);
		die();
	}else{
		logMessage("201","Corredor inserido com sucesso.");
		die();
	}
	$conn->close();

});

//ATUALIZAR CORREDOR
$app->put('/runners/:id',function($id){
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
			if($key == 'data_nascimento') $value = dateInverter($value);
			$update[] = $key."='".htmlentities(trim($value))."'";
		}
		$update = implode(",",$update);
		$sql = "UPDATE corredor SET ".$update." WHERE id=".$id;
		$ok = $conn->query($sql);			
		if(!$ok) {
			logMessage("503","Erro ao atualizar corredor: " . $conn->connect_error);
			die();
		}else{
			logMessage("202","Corredor atualizado com sucesso.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao atualizar corredor. O ID precisa ser numerico.");
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
			logMessage("200","Corredor deletado.");
			die();
		}else {
			logMessage("503","Erro ao deletar corredor.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao deletar corredor. O ID precisa ser numerico.");
		die();
	}
});


//BUSCAR INSCRICOES DE UM CORREDOR, COM INFORMAÇÕES DA CORRIDA
$app->get('/runners/:id/runsEntry',function($runnerId){
	if(is_numeric($runnerId)){
		$conn = getConn();
		$sql = "SELECT  inscricao.id as id_inscricao,
						inscricao.id_corredor as id_corredor,
						inscricao.id_corrida as id_corrida,
						inscricao.status as status_pagamento,
						corridas.* 
						FROM inscricao 
						LEFT JOIN corridas ON corridas.id = inscricao.id_corrida 
						WHERE inscricao.id_corredor = ".$runnerId;
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