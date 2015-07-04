<?

	function inverterDate($date){
		$data = explode("/",$date);
		return $data[2]."-".$data[1]."-".$data[0];
	}

	if(isset($_POST['tipo'])){

		if($_POST['tipo'] == 'corredor'){
			
			$_POST['datanascimento'] = inverterDate($_POST['datanascimento']);

			$curl = curl_init("http://www.ceolato.com.br/wsg4server/corredores/".$_POST['idcorredor']);
			$data = $_POST;
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

			// Make the REST call, returning the result
			$response = curl_exec($curl);
			if (!$response) {
				die("Erro ao alterar corredor");
			}

		}elseif($_POST['tipo'] == 'corrida'){

			$_POST['data'] = inverterDate($_POST['data']);

			$curl = curl_init("http://www.ceolato.com.br/wsg4server/corridas/".$_POST['idcorrida']);
			$data = $_POST;
			curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
			curl_setopt($curl, CURLOPT_HEADER, false);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));

			// Make the REST call, returning the result
			$response = curl_exec($curl);
			if (!$response) {
				die("Erro ao alterar corrida");
			}

		}

	}

	header("Location: ".$_SERVER['HTTP_REFERER']);

?>