<?php
session_start();
// Su dung voi cau lenh query: insert, update, delete -> ko tra ve ket qua.
function execute($sql) {
	$conn = mysqli_connect('localhost','root','','phphorizon', 3301);
	mysqli_set_charset($conn, 'utf8');
	mysqli_query($conn, $sql);
	mysqli_close($conn);
}

function executeResult($sql,$isSingle = false) {
	$conn = mysqli_connect('localhost','root','','phphorizon', 3301);
	$resultset = mysqli_query($conn, $sql) or die('query failed');
	if($isSingle)
		return mysqli_fetch_assoc($resultset);
	$data = [];
	while($row = mysqli_fetch_assoc($resultset)) 
		$data[] = $row;	
	mysqli_close($conn);
	return $data;
}
function fixSqlInjection($str) {
	// abc\okok -> abc\\okok
	//abc\okok (user) -> abc\okok (server) -> sql (abc\okok) -> xuat hien ky tu \ -> ky tu dac biet -> error query
	//abc\okok (user) -> abc\okok (server) -> convert -> abc\\okok -> sql (abc\\okok) -> chinh xac
	$str = str_replace('\\', '\\\\', $str);
	//abc'okok -> abc\'okok
	//abc'okok (user) -> abc'okok (server) -> sql (abc'okok) -> xuat hien ky tu \ -> ky tu dac biet -> error query
	//abc'okok (user) -> abc'okok (server) -> convert -> abc\'okok -> sql (abc\'okok) -> chinh xac
	$str = str_replace('\'', '\\\'', $str);

	return $str;
}

//function authenToken() {
//	if (isset($_SESSION['user'])) {
//		return $_SESSION['user'];
//	}
//
//	$token = getCOOKIE('token');
//	if (empty($token)) {
//		return null;
//	}
//
//	$sql    = "select users.* from users, login_tokens where users.id = login_tokens.id_user and login_tokens.token = '$token'";
//	$result = executeResult($sql);
//
//	if ($result != null && count($result) > 0) {
//		$_SESSION['user'] = $result[0];
//
//		return $result[0];
//	}
//
//	return null;
//}

function getPOST($key) {
	$value = '';
	if (isset($_POST[$key])) {
		$value = $_POST[$key];
	}
	return fixSqlInjection($value);
}

//function getCOOKIE($key) {
//	$value = '';
//	if (isset($_COOKIE[$key])) {
//		$value = $_COOKIE[$key];
//	}
//	return fixSqlInjection($value);
//}

function getGET($key) {
	$value = '';
	if (isset($_GET[$key])) {
		$value = $_GET[$key];
	}
	return fixSqlInjection($value);
}

?>