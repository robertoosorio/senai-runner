<?php

//BUSCAR INSCRIÇÃO
$app->get('/runsEntry',function(){
	$conn = getConn();
	$r = $conn->query("SELECT * FROM inscricao ORDER BY data DESC");
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
		logMessage("204","Nenhuma inscricao encontrada");
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
			logMessage("204","Nenhuma inscricao encontrada.");
			die();
		}
	}else {
		logMessage("203","Erro ao buscar inscricao. O ID precisa ser numerico.");
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
		logMessage("503","Erro ao inserir inscricao: " . $conn->connect_error);
		die();
	}else{
		logMessage("201","Inscricao inserida com sucesso.");
		die();
	}
	$conn->close();

});

//ATUALIZAR INSCRIÇÃO
$app->put('/runsEntry/:id',function($id){
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
			$update[] = $key."='".htmlentities(trim($value))."'";
		}
		$update = implode(",",$update);
		$sql = "UPDATE inscricao SET ".$update." WHERE id=".$id;
		$ok = $conn->query($sql);			
		if(!$ok) {
			logMessage("503","Erro ao atualizar inscricao: " . $conn->connect_error);
			die();
		}else{
			logMessage("202","Inscricao atualizada com sucesso.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao atualizar inscricao. O ID precisa ser numerico.");
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
			logMessage("200","Inscricao deletada.");
			die();
		}else {
			logMessage("503","Erro ao deletar inscricao.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao deletar inscricao. O ID precisa ser numerico.");
		die();
	}
});



//BUSCAR INSCRICAO
$app->get('/runners/:runnerId/runs/:runId',function($runnerId,$runId){
	if(is_numeric($runnerId) && is_numeric($runId)){
		$conn = getConn();
		$r = $conn->query("SELECT * FROM inscricao WHERE id_corrida = ".$runId." AND id_corredor = ".$runnerId);
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
			logMessage("204","Nenhuma inscricao encontrada");
			die();
		}
	}else{
		logMessage("203","Erro ao buscar inscricao. Os IDs precisam ser numericos.");
		die();
	}	$conn->close();
});

//CADASTRAR INSCRICAO
$app->post('/runners/:runnerId/runs/:runId',function($runnerId,$runId){
	if(is_numeric($runnerId) && is_numeric($runId)){
		$_POST['id_corredor'] = $runnerId;
		$_POST['id_corrida'] = $runId;
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
		$sql = "INSERT INTO inscricao(".$keys.") VALUES (".$values.")";
		$ok = $conn->query($sql);
		if(!$ok) {
			logMessage("503","Erro ao inserir inscricao: " . $conn->connect_error);
			die();
		}else{
			logMessage("201","Inscricao inserido com sucesso.");
			die();
		}
	}else{
		logMessage("203","Erro ao cadastrar inscricao. Os IDs precisam ser numericos.");
		die();
	}
	$conn->close();

});

//ATUALIZAR INSCRICAO
$app->put('/runners/:runnerId/runs/:runId',function($runnerId,$runId){
	if(is_numeric($runnerId) && is_numeric($runId)){
		$conn = getConn();
		if(isset($_POST['_METHOD'])) unset($_POST['_METHOD']);
		$dados = cleanup($_POST,false);
		$update = array();
		foreach ($dados as $key => $value) {
			if($key == 'data_nascimento') $value = dateInverter($value);
			$update[] = $key."='".htmlentities(trim($value))."'";
		}
		$update = implode(",",$update);
		$sql = "UPDATE inscricao SET ".$update." WHERE id_corredor=".$runnerId." AND id_corrida = ".$runId;
		$ok = $conn->query($sql);			
		if(!$ok) {
			logMessage("503","Erro ao atualizar inscricao: " . $conn->connect_error);
			die();
		}else{
			logMessage("202","Inscricao atualizado com sucesso.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao atualizar inscricao. O ID precisa ser numerico.");
		die();
	}
});

//DELETAR INSCRICAO CORREDOR
$app->delete('/runners/:runnerId/runs/:runId',function($runnerId,$runId){
	if(is_numeric($runnerId) && is_numeric($runId)){
		$conn = getConn();
		$sql = "DELETE FROM inscricao WHERE id_corredor = ".$runnerId." AND id_corrida = ".$runId;
		$r = $conn->query($sql);
		if($r) {
			logMessage("200","Inscricao deletada.");
			die();
		}else {
			logMessage("503","Erro ao deletar inscricao.");
			die();
		}
		$conn->close();
	}else{
		logMessage("203","Erro ao deletar inscricao. Os IDs precisam ser numericos.");
		die();
	}
});