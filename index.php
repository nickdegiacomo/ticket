<?if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();?>
<?include('brix/config.php');?>
<?include('brix/global_functions.php');?>
<?if(isLogged()){?>
<?$username=getUsername(); $name = getName($username); $email = getEmail($username); $error = $info = ''; ?>
<?if(isset($_POST['update'])){ $fields = array('first_name','last_name','email'); $error = validateFields($fields);
	if($error == ''){
		$pass = S_POST('pass');
		if(!validateSessionPassword($username,$pass)){
			$error = 'The current password is invalid';
		} else if(!empty($_POST['newpass'])){
			$newpass = S_POST('newpass');
			if(validPassword($newpass)){
				if($newpass == $pass){
					$error = 'The current password and the new password cannot be the same';
				} else {
					$con = connect();
					$fn = S_POST('first_name');
					$ln = S_POST('last_name');
					$em = S_POST('email');
					$newpass = crypt(sha1($newpass));
					mysql_query("UPDATE users SET first_name='$fn',last_name='$ln',email='$em',password='$newpass' WHERE username='$username'") or die(mysql_error());
					disconnect($con);
					$username=getUsername(); $name = getName($username); $email = getEmail($username);
					$info = 'Your account information has been updated. You will be logged out in 5 seconds..';
					?><META HTTP-EQUIV="REFRESH" CONTENT="5;logout.php" /><?
				}
			} else {
				$error = 'The new password can only contain alphanumeric characters and must be between 7 and 21 characters long';
			}
		} else {
			$con = connect();
			$fn = S_POST('first_name');
			$ln = S_POST('last_name');
			$em = S_POST('email');
			mysql_query("UPDATE users SET first_name='$fn',last_name='$ln',email='$em' WHERE username='$username'") or die(mysql_error());
			disconnect($con);
			$username=getUsername(); $name = getName($username); $email = getEmail($username);
			$info = 'Your account information has been updated';
		}
	}
}?>
<?include('inc/header.php');?>
	<h1>My account</h1>
	<div>
		<div style="margin-bottom:10px;">Welcome to your account, <strong><?=$name[0]?></strong>!</div>
		<?if($error != ''){
			printError($error);
		} else if($info != ''){
			printInfo($info);
		}?>
		<div style="height:160px;margin-top:10px;">
			<div class="form fleft" style="width:660px;">
				<form method="post" action="index.php">
				<ul class="layout">
					<li>
						First name<br />
						<input type="text" value="<?=$name[0]?>" name="first_name" class="input" />
					</li>
					<li>
						Last name<br />
						<input type="text" value="<?=$name[1]?>" name="last_name" class="input" />
					</li>
					<li>
						Username<br />
						<input type="text" value="<?=$username?>" class="input" DISABLED />
					</li>
				</ul>
				<ul class="layout">
					<li>
						E-Mail<br />
						<input type="text" value="<?=$email?>" name="email" class="input" />
					</li>
					<li>
						Password<br />
						<input type="password" value="" name="pass" class="input" />
					</li>
					<li>
						New password<br />
						<input type="password" value="" name="newpass" class="input" />
					</li>
				</ul>
				<div align="right">
					<div align="right" style="margin-top:5px;">
						<input type="submit" value="Update" name="update" id="update" />
					</div>
				</div>
				</form>
			</div>
			<div class="tips fright" style="width:290px;">
				<div class="title">
					Tips
				</div>
				<ul>
					<li>In order to update any of the fields on the left make sure you type in your current password into the <b>Password</b> field.</li>
					<li>The <b>New password</b> field is not mandatory, but if you fill it in, thus you want to change the current password, it must comply with the password rules.</li>
				</ul>
			</div>
		</div>
	</div>
<?include('inc/footer.php');?>
<?unset($username); unset($name); unset($email); unset($error);?>
<?}else{
	header('Location: login.php');
}?>
