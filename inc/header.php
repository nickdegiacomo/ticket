<?$page=currentPageName();?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?header('Content-type: text/html; charset=utf-8');?>
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
<meta name="author" content="Andrei Design" /><!--BRIX, v.1.0-->
<link href="http://fonts.googleapis.com/css?family=Oswald" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/themes/dark-hive/jquery-ui.css" type="text/css" />
<link href="css/main.css" rel="stylesheet" type="text/css" media="screen" />
<link rel="SHORTCUT ICON" href="img/favicon.ico" /> 
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.15/jquery-ui.min.js"></script>
<title>Brix&trade; - Andrei Design CMS</title>
</head>
<body>
<center>
	<div id="main-container">
		<div id="main">
			<div id="menu-container">
				<?include('inc/menu.php');?>
				<div id="greeting">
					Welcome, <strong><?=$name[0]?></strong>! [<a href="logout.php">Logout</a>]
				</div>
			</div>
			<div id="logo-container">
				<a href="logout.php">
					<div id="logo"></div>
				</a>
			</div>
			<div id="content">
				<?if(!isset($_COOKIE['notified'])){
					if(!isUpToDate() && !isset($_GET['notify'])){
						printError('Brix&trade; is out of date! Click <a href="index.php?notify"><b>here</b></a> to notify Andrei Design to bring it to the current version');
						echo '<br />';
					} else if(isset($_GET['notify'])){
						setcookie('notified','true',time()+3600*24*7);
						$info = 'Andrei Design has been notified and you will receive an e-mail when the upgrade to the new version is complete';
					}
				}?>		
