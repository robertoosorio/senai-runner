<?php

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
	header('X-PHP-Response-Code: '.$codigo, true, $codigo);
	$arr = array("code" => $codigo,
				"description" => htmlentities($mensagem));
	print_r(json_encode($arr));
}
