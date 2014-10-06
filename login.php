<?if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();?>
<?include('brix/config.php');?>
<?include('brix/global_functions.php'); $error = $info = '';?>
<?if(isset($_POST['login'])){ $error = login(); } else { if(isLogged()){ header('Location: index.php'); } }?>
<?if(isset($_POST['send'])){ $error = reminder(); if($error == 'Password reset instructions have been sent'){ $info = $error; $error = ''; } }?>
<?if(isset($_GET['e']) && is_numeric($_GET['e'])){ $error = getError($_GET['e']); }?> 
<?header('Content-type: text/html; charset=utf-8');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/themes/dark-hive/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="css/login.css" type="text/css" />
<link rel="SHORTCUT ICON" href="img/favicon.ico" /> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"></script>
<title>Restricted area</title>
</head>
<body>
<div id="content-holder">
	<?if($error != ''){
		printError($error);
	} else if($info != ''){
		printInfo($info);
	}?>
	<div id="content">
		<div id="inner">
			<div class="left">
				<div class="title">Restricted area</div>
				<form method="post" action="login.php">
					Username<br />
					<input type="text" value="<?if(isset($_POST['user'])){ print $_POST['user']; }?>" name="user" class="input" />
					<br />
					Password<br />
					<input type="password" value="" name="pass" class="input" />
					<br />
					<div align="right" style="margin-top:5px;">
						<input type="submit" value="Login" name="login" id="login" />
					</div>
				</form>
			</div>
			<div class="right">
				<div class="title">Lost your password?</div>
				<div style="font-size:12px; height:30px;">
					Type your e-mail to receive instructions on how to reset your password.
				</div>
				<br />
				E-mail
				<br />
				<form method="post" action="login.php">
					<input type="text" value="" name="email" class="input" />
					<div align="right" style="margin-top:5px;">
						<input type="submit" value="Send" name="send" id="send" />
					</div>
				</form>
			</div>
			<center>
				<div class="vbreak"></div>
			<center>
		</div>
	</div>
	<div style="float:right;height:25px;margin-top:5px;">
		<a href="http://brix.andreidesign.com" target="_blank"><img src="img/brix.png" width="83" height="25" title="Built on Brix" /></a>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#login,#send').button();
		<?if($error != ''){?>
		$('#content').effect("shake", { times:3 }, 70);
		if($('.error').length != 0){
			$('.error').prepend('<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>');
			$('.error').wrapInner('<p />');
			$('.error').wrapInner('<div class="ui-state-error" style="padding: 0 .7em;" />');
			$('.error').wrapInner('<div class="ui-widget" style="font-size:12px;" />');
		}
		<?}?>
		<?if($info != ''){?>
		if($('.info').length != 0){
			$('.info').prepend('<span class="ui-icon ui-icon-info" style="float: left; margin-right: .3em;"></span>');
			$('.info').wrapInner('<p />');
			$('.info').wrapInner('<div class="ui-state-highlight" style="padding: 0 .7em;" />');
			$('.info').wrapInner('<div class="ui-widget" style="font-size:12px;" />');
		}
		<?}?>
	});
</script>
</body>
</html>
