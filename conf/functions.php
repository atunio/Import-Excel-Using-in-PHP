<?php

$timezone = "Asia/Karachi";
$add_ip		= $_SERVER['REMOTE_ADDR'];
$add_date	= date("Y-m-d H:i:s");

class mySqlDB
{
	// Methods
	function query($conn, $query)
	{
		return mysqli_query($conn, $query);
	}
	function counter($result)
	{
		return mysqli_num_rows($result);
	}
	function fetch($result)
	{
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
}

function remove_special_character($field)
{
	// single and double codes = &#039;, &quot;
	if (isset($field) && $field != "") {
		$field = str_replace(array("'", "$", "\"", "&#039;", "&quot;", "=", "||", "%"), "", $field);
	}
	return $field;
}


function encrypt($sData)
{
	$sKey = '24234#dd1133a$a123-*';
	$sResult = '';
	for ($i = 0; $i < strlen($sData); $i++) {
		$sChar    = substr($sData, $i, 1);
		$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
		$sChar    = chr(ord($sChar) + ord($sKeyChar));
		$sResult .= $sChar;
	}
	return encode_base64($sResult);
}
function decrypt($sData)
{
	$sKey = '24234#dd1133a$a123-*';
	$sResult = '';
	$sData   = decode_base64($sData);

	for ($i = 0; $i < strlen($sData); $i++) {
		$sChar    = substr($sData, $i, 1);
		$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
		$sChar    = chr(ord($sChar) - ord($sKeyChar));
		$sResult .= $sChar;
	}
	return $sResult;
}
function encode_base64($sData)
{
	$sBase64 = base64_encode($sData);
	return strtr($sBase64, '+/', '-_');
}
function decode_base64($sData)
{
	$sBase64 = strtr($sData, '-_', '+/');
	return base64_decode($sBase64);
}

function set_replace_string_char($data)
{
	$replace_data = str_replace(array(',', "'"), '', $data);
	return $replace_data;
}
