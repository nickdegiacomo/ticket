<?
function disconnect($con){
	mysql_close($con);
}

function isUpToDate(){
	$v = '1.0';
	$online_ver = '1.1';
	if($v == $online_ver)
		return true;
	return false;
}

function loadBrix($var){
	$dir = S_SET($var);
	$path = 'brix/'.$dir.'/';
	if(is_dir('./brix/'.$dir)){
		if(isset($_GET['add'])){
			return $path.'add.php';
		} else if(isset($_GET['edit'])){
			return $path.'edit.php';
		} else if(isset($_GET['delete'])){
			return $path.'delete.php';
		} else {
			return $path.'main.php';
		}
	}
	$dir = str_replace('_',' ',$dir);
	return printError('The <b>'.strtoupper($dir).'</b> Brick could not be found');
}

function login(){
	if(!empty($_POST['user']) && !empty($_POST['pass'])){
		$user = S_POST('user');
		$pass = S_POST('pass');
		$con = connect();
		$q = mysql_query("SELECT password FROM users WHERE username='$user'");
		$q = mysql_fetch_array($q);
		if(crypt(sha1($pass),$q['password']) == $q['password']){
			$timest = date('Y-m-d H:i:s');
			$id = generateId();
			$ip = $_SERVER['REMOTE_ADDR'];
			mysql_query("UPDATE users SET last_ip='$ip',last_access='$timest' WHERE username='$user'") or die(mysql_error());
			mysql_query("DELETE FROM sessions WHERE username='$user'") or die(mysql_error());
			mysql_query("INSERT INTO sessions(unique_id,username,ip,timestamp) VALUES ('$id','$user','$ip','".time()."')") or die(mysql_error());
			disconnect($con);
			setcookie('ms1',sha1($id),time()+5400);
			setcookie('ms2',sha1($user),time()+5400);
			header('Location: index.php');
		} 
		disconnect($con);
		return 'Username and password do not match';
	}
	return 'Please fill in all fields';
}

function isLogged(){
	if(isset($_COOKIE['ms1'])) $session_id = $_COOKIE['ms1'];
	if(isset($_COOKIE['ms2'])) $session_user = $_COOKIE['ms2'];
	if(isset($session_id) && isset($session_user)){
		$con = connect();
		$q = mysql_query("SELECT unique_id,username,ip,timestamp FROM sessions");
		while($r = mysql_fetch_array($q)){
			if((sha1($r['unique_id']) == $session_id)
			&& (sha1($r['username']) == $session_user)
			&& (time()-5400-intval($r['timestamp']) < 0)){
				disconnect($con);
				return true;
			}
		}
		disconnect($con);
		return false;
	}
	return false;
}

function S_POST($var){
	return htmlspecialchars($_POST[$var], ENT_QUOTES);
}

function S_GET($var){
	return htmlspecialchars($_GET[$var], ENT_QUOTES);
}

function S_SET($var){
	return htmlspecialchars($var, ENT_QUOTES);
}

function getUsername(){
	if(isset($_COOKIE['ms1'])) $session_id = $_COOKIE['ms1'];
	if(isset($_COOKIE['ms2'])) $session_user = $_COOKIE['ms2'];
	if(isset($session_id) && isset($session_user)){
		$con = connect();
		$q = mysql_query("SELECT username FROM sessions");
		while($r = mysql_fetch_array($q)){
			if(sha1($r['username']) == $session_user){
				disconnect($con);
				return $r['username'];
			}
		}
		disconnect($con);
		return 'error';
	}
	return 'error';
}

function getName($username){
	$con = connect();
	$user = mysql_query("SELECT first_name,last_name FROM users WHERE username='$username'");
	$user = mysql_fetch_array($user);
	disconnect($con);
	return $user;
}

function getEmail($username){
	$con = connect();
	$email = mysql_query("SELECT email FROM users WHERE username='$username'");
	$email = mysql_fetch_array($email);
	disconnect($con);
	return $email[0];
}

function getRole($username){
	$con = connect();
	$role = mysql_query("SELECT role FROM users WHERE username='$username'");
	$role = mysql_fetch_array($role);
	disconnect($con);
	return $role[0];
}

function emailHTML($to,$from,$subject,$message){
	$headers = "From: $from \r\n";
	$headers .= "Content-type: text/html \r\n";
	$headers .= "Reply-To: $from \r\n";
	$headers .= "Return-path: $from";
	mail($to, $subject, $message, $headers);
}

function reminder(){
	if(isset($_POST['email']) && !empty($_POST['email'])){
		$email = $_POST['email'];
		if(validEmail($email)){
			$con = connect();
			$q = mysql_query("SELECT id,email FROM users WHERE email='$email'");
			$r = mysql_fetch_array($q);
			if(!empty($r['email'])){
				include('config.php');
				$key = generateID(30,1);
				$id = $r['id'];
				$ip = $_SERVER['REMOTE_ADDR'];
				$timestamp = date('Y-m-d H:i:s',strtotime('+30 minutes'));
				mysql_query("INSERT INTO reset_keys(reset_key,user_id,ip,expires) VALUES ('$key','$id','$ip','$timestamp')") or die(mysql_error());
				$from = 'no-reply@'.$domain;
				$domain = str_replace('http://www.','',$link);
				$title = 'Reset password';
				$message = 'Dear user,<br />
							<br />
							The IP address '.$ip.' has requested on '.date('m/d/Y').' at '.date('H:i').' to reset the password of your account at <a href="'.$link.'" target="_blank">'.$link.'</a>. If you did not make this request please contact us immediately at <strong>badrequest@'.$domain.'</strong>. If you are the person who made the request then read below:<br />
							<br />
							In order to <strong>reset your password</strong> please visit the following link<br /><br />
							<div style="background:#FFFF99;padding:5px;"><strong><a href="'.$link.'/reset.php?key='.$key.'" target="_blank">'.$link.'/reset.php?key='.$key.'</a></strong></div><br />
							then follow the instructions on that page. If you cannot click the link, copy and paste it into your browser\'s address bar.';
				$footmsg = 'Best regards,<br />
							<a href="'.$link.'" target="_blank"><strong>'.$company.'</strong></a><br />
							contact@andreidesign.com';
				$spamnote = 'This message is not unsolicited. You are receiving this message because somebody requested to reset the password of your account associated with one of your <a href="http://www.andreidesign.com/" target="_blank"><strong>Andrei Design</strong></a> services.';
				include('inc/email_template.php');
				$to = $r['email'];
				disconnect($con);
				emailHTML($to,$from,$title,$template);
				return 'Password reset instructions have been sent';
			}
			disconnect($con);
			return 'This e-mail does not match our database';
		}
		return 'Please type a valid e-mail address';
	}
	return 'Please type your e-mail address';
}

function dataFoundIn($var){
	$con = connect();
	$q = mysql_query("SELECT count(*)FROM $var");
	$q = mysql_fetch_array($q);
	disconnect($con);
	if($q[0] > 0)
		return '';
	$var = str_replace('_',' ',$var);
	return 'There are currently no '.$var.' in the database';
}

function validResetKey(){
	if(isset($_GET['key']) || isset($_POST['rkey'])){
		if(isset($_GET['key'])){
			$key = S_GET('key');
		} else {
			$key = S_POST('rkey');
		}
		$con = connect();
		$q = mysql_query("SELECT ip,expires FROM reset_keys WHERE reset_key='$key'");
		$r = mysql_fetch_array($q);
		if(!empty($r['ip']) && !empty($r['expires'])){
			if($r['expires'] > date('Y-m-d H:i:s')){
				return 0;
			}
			return 1;
		}
		return 3;
	}
	return 4;
}

function resetPassword($var){
	if(!empty($_POST['pass']) && !empty($_POST['repass'])){
		$pass = S_POST('pass');
		$repass = S_POST('repass');
		if(validPassword($pass) && validPassword($repass)){
			if($pass == $repass){
				$key = S_SET($var);;
				$newpass = crypt(sha1($pass));
				$con = connect();
				$q = mysql_query("SELECT user_id FROM reset_keys WHERE reset_key='$key'");
				$r = mysql_fetch_array($q);
				mysql_query("UPDATE users SET password='$newpass' WHERE id='{$r['user_id']}'");
				mysql_query("DELETE FROM reset_keys WHERE user_id='{$r['user_id']}'");
				disconnect($con);
				return 'Your password has been reset';
			}
			return 'The two passwords do not match';
		}
		return 'Passwords can only contain alphanumeric characters and must be between 7 and 21 characters long';
	}
	return 'Please fill in all fields';
}

function validateSessionPassword($user,$pass){
	$con = connect();
	$q = mysql_query("SELECT password FROM users WHERE username='$user'");
	$r = mysql_fetch_array($q);
	disconnect($con);
	if($r['password'] == crypt(sha1($pass),$r['password'])){
		return true;
	}
	return false;
}

function validateFields($array){
	foreach ($array as $field) {
		if(empty($_POST[$field])){
			unset($field);
			return 'Please fill in all fields';
		} else if($field == 'email' && !validEmail(S_POST($field))){
			unset($field);
			return 'Please type in a valid e-mail address';
		} else if($field == 'pass' && !validPassword(S_POST($field))){
			unset($field);
			return 'Passwords can only contain alphanumeric characters and must be between 7 and 21 characters long';
		}
	}
	unset($field);
	return '';
}

function validPassword($var){
	if(ctype_alnum($var)
	&& strlen($var)>6
	&& strlen($var)<21){
		return true;
	}
	return false; 
}

function validEmail($email){
	if (!preg_match("/^[[:alnum:]][a-z0-9_.-]*@[a-z0-9.-]+\.[a-z]{2,4}$/i", $email)) {
		return false;
	} else {
		return true;
	}
}

function getError($var){
	if($var == 1){
		return 'Reset key has expired';
	} else if($var == 2){
		return 'IP is unauthorized to use this reset key';
	} else if($var == 3){
		return 'Reset key does not exist';
	} else if($var == 4){
		return 'You are unauthorized to use the reset page';
	}
	return 'Unknown error';
}

function generateID($length=20,$type=1){
	$key = '';
	switch($type){
		case 2:
			$pattern = "abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyz";
			break;
		case 3:
			$pattern = "12345678901234567890123456789012345678901234567890";
			break;
		default:
			$pattern = "1234567890abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			break;
	}
	for($i=0;$i<$length;$i++){
		$key .= $pattern{rand(0,51)};
	}
   return $key;
}

function currentPageName() {
	return substr($_SERVER['SCRIPT_NAME'],strrpos($_SERVER['SCRIPT_NAME'],'/')+1);
}

function printWarning($msg){
	echo '<div class="error"><strong>Warning:</strong> '.$msg.'!</div>';
}

function printError($msg){
	echo '<div class="error"><strong>Error:</strong> '.$msg.'.</div>';
}

function printInfo($msg){
	echo '<div class="info"><strong>Info:</strong> '.$msg.'.</div>';
}
?>
