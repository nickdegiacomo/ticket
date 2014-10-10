<?
$link = 'http://www.example.com';
$logo = 'images/abc.png';
$company = 'Website name';

function connect(){
	$bd_host = 'mybrixdb.cexyqq6xpyhc.us-west-2.rds.amazonaws.com';
	$bd_user = 'mybrixuser';
	$bd_password = '!@#$%W8BQbAMChMB!$#@!';
	$bd_name = 'mybrixdb';
	$con = mysql_connect($bd_host, $bd_user, $bd_password);
	mysql_select_db($bd_name, $con);
	return $con;
}

function is_parent($var,$parents){
	$n = count($parents);
	for($i=0;$i<$n;$i++){
		if($parents[$i] == $var){
			return true;
		}
	}
	return false;
}

function get_parent_index($var,$parents){
	$n = count($parents);
	for($i=0;$i<$n;$i++){
		if($parents[$i] == $var){
			return $i;
		}
	}
	return -1;
}

function is_child($var,$children){
	$n = count($children);
	for($i=0;$i<$n;$i++){
		if($children[$i] == $var){
			return true;
		}
	}
	return false;
}

$parents = array('projects','requests');
$children = array('project_types','package_types','request_types');
$cement = array(array());
//Children of Projects
$cement[0][0] = $children[0];
$cement[0][1] = $children[1];
$cement[1][0] = $children[2];
?>
