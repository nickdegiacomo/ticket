<?
$template = '<html>
<head>
<style type="text/css">
a img {border: none;}
a {color:#000000;text-decoration:none;}
a:visited{color:#000000;}
a:hover{color:#000000;}
body {background-color:#FFFFFF;font-size:12px;}
</style>
</head>
<body>
<center>
	<div style="border:1px solid #333333;background:#ffffff;width:512px;" align="left">
		<div style="padding:10px;">
			<a href="'.$link.'" target="_blank">
				<div style="height:60px;margin-bottom:10px;">
					<img src="'.$logo.'" title="'.$company.'" />
				</div>
			</a>
			<div style="margin-bottom:10px;">
				<strong>'.$title.'</strong><br />
				<span style="font-size:12px;">Sent on '.date('m/d/Y').'</span>
			</div>
			<div style="margin-bottom:10px;">
				'.$message.'
			</div>
			<div>
				'.$footmsg.'
			</div>
		</div>
		<div style="background:#FFFF99;padding:10px;font-size:12px;">
			'.$spamnote.'
		</div>
	</div>
</center>
</body>
</html>';
?>
