<?if(substr_count($_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) ob_start("ob_gzhandler"); else ob_start();?>
<?include('brix/config.php');?>
<?include('brix/global_functions.php'); $error = $info = '';?>
<?if(isLogged()){ header('Location: index.php'); }?>
<?$e = validResetKey(); if($e == 0){ if(isset($_GET['key'])){ $reset_key = htmlspecialchars($_GET['key'], ENT_QUOTES); } else { $reset_key = htmlspecialchars($_POST['rkey'], ENT_QUOTES); } } else { header('Location: login.php?e='.$e); } ?>
<?if(isset($_POST['reset'])){ $error = resetPassword($reset_key); if($error == 'Your password has been reset'){ $info = $error; $error = ''; } }?>
<?header('Content-type: text/html; charset=utf-8');?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/themes/dark-hive/jquery-ui.css" type="text/css" />
<link rel="stylesheet" href="css/login.css" type="text/css" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"></script>
<title>Reset your password</title>
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
				<div class="title">Reset your password</div>
				<form method="post" action="reset.php">
					<input type="hidden" value="<?=$reset_key?>" name="rkey" />
					New password<br />
					<input type="password" value="" name="pass" class="input" />
					<br />
					Re-type new password<br />
					<input type="password" value="" name="repass" class="input" />
					<br />
					<div align="right" style="margin-top:5px;">
						<input type="submit" value="Reset" name="reset" id="reset" />
					</div>
				</form>
			</div>
			<div class="right">
				<div class="title">Done with this page?</div>
				<div style="font-size:12px; height:30px;">
					Click <a href="login.php">here</a> to go back to the login panel.
				</div>
			</div>
			<center>
				<div class="vbreak"></div>
			<center>
		</div>
	</div>
	<div style="float:right;height:25px;margin-top:5px;">
		<a href="http://brix.andreidesign.com" target="_blank"><img src="img/brix.png" width="75" height="25" title="Built on Brix" /></a>
	</div>
</div>
<script>
	$(document).ready(function() {
		$('#reset').button();
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
