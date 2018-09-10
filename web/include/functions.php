<?php
//ini_set ( 'display_errors', 1 );
//ini_set ( 'display_startup_errors', 1 );
error_reporting ( 0 );
include ("DbConnect.php");
function existsRecord($query) {
	$results = mysql_query ( $query ) or die ( mysql_error () . " connection failed" );
	$num = mysql_num_rows ( $results );
	
	if ($num > 0) {
		return true;
	} else {
		return false;
	}
}
function executeQuery($query) {
	$results = mysql_query ( $query ) or die ( mysql_error () . "connection failed in Execute Query" );
	if ($results) {
		return true;
	} else {
		return false;
	}
}
function getRecord($query, $field_name, $flag) {
	$results = mysql_query ( $query ) or die ( mysql_error () . " connection failed" );
	$num = mysql_num_rows ( $results );
	$flag = $flag == '' ? 0 : $flag;
	if ($num > 0) {
		$rows = mysql_fetch_array ( $results );
		return $rows [$flag];
	} else {
		return "No Records";
	}
}
function getQueryRecord($query) {
	$rows = '';
	$results = mysql_query ( $query ) or die ( mysql_error () . " connection failed" );
	$num = mysql_num_rows ( $results );
	if ($num > 0) {
		$rows = mysql_fetch_assoc ( $results );
		
		return $rows;
	} else {
		return $rows;
	}
}
function recordSet($query) {
	$results = mysql_query ( $query ) or die ( mysql_error () . " connection failed" );
	$num = mysql_num_rows ( $results );
	if ($num > 0) {
		$row = mysql_fetch_array ( $results );
		return $row;
	}
}
function getIp() {
	return $_SERVER ['REMOTE_ADDR'];
}
function checkInputs($formData) {
	if (empty ( $formData )) {
		return 0;
	}
	$result = array ();
	$triple = array ();
	//echo'<pre>';print_r($formData);exit;
	$err1=array();
	foreach ( $formData as $key => $val ) {
		/**
		 * validate triple value is empty or not
		 */

		if ($key == 'single') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				$result ['1']  = remove_empty ( $val );
			}
		}
		
		if ($key == 'two') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				$result ['2']  = remove_empty ( $val );
			}
		}
		
		if ($key == 'san') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data=>$one){
					$triple[$data] = $one;
				}
				//$result ['triple']  = remove_empty ( $info );
				
			}
		}
		if ($key == 'che') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data1=>$one1){
					$triple[$data1] = $one1;
				}
				//$result ['triple'] = remove_empty ( $info1 );
			}
		}
		if ($key == 'sup') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data2=>$one2){
					$triple[$data2] = $one2;
				}
				//$result ['triple']  = remove_empty ( $info2 );
			}
		}
		
		if ($key == 'del') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data3=>$one3){
					$triple[$data3] = $one3;
				}
				//$result ['triple']  = remove_empty ( $info3 );
			}
		}
		
		if ($key == 'bha') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data4=>$one4){
					$triple[$data4] = $one4;
				}
				
				//$result ['triple']  = remove_empty ( $info4 );
			}
		}
		if ($key == 'dia') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data5=>$one5){
					$triple[$data5] = $one5;
				}
				//$result ['triple']  = remove_empty ( $info5 );
			}
		}
		if ($key == 'luk') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data6=>$one6){
					$triple[$data6] = $one6;
				}
				//$result ['triple']  = remove_empty ( $info6 );
			}
		}
		
		if ($key == 'new1') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data7=>$one7){
					$triple[$data7] = $one7; 
				}
				//$result ['triple']  = remove_empty ( $info7 );
			}
		}
		if ($key == 'new2') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data8=>$one8){
					$triple[$data8] = $one8;
				}
				//$result ['triple']  = remove_empty ( $info8 );
			}
		}
		if ($key == 'new3') {
			if (! empty ( $val ) && array_sum ( $val ) != 0) {
				foreach($val as $data9=>$one9){
					$triple[$data9] = $one9;
				}
			//	$result ['triple']  = remove_empty ( $info9 );
			}
		}
		
		
		
	
	}
	$triple = remove_empty ($triple);
	if(!empty($triple)){
		$result['3'] = remove_empty ($triple);	
	}
	return $result;
}
function remove_empty($array) {
	return array_filter ( $array, '_remove_empty_internal' );
}
function _remove_empty_internal($value) {
	return ! empty ( $value ) || $value === 0;
}

function arrayToObject($array) {
	if (!is_array($array)) {
		return $array;
	}
	$object = new stdClass();
	if (is_array($array) && count($array) > 0) {
		foreach ($array as $name=>$value) {
			$name = trim($name);
			if (!empty($name)) {
				$object->$name = arrayToObject($value);
			}
		}
		return $object;
	} else {
		return FALSE;
	}
}


?>