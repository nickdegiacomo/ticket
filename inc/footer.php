			</div>
		</div>
		<div style="float:right;height:25px;margin-top:5px;">
			<a href="http://brix.andreidesign.com" target="_blank"><img src="img/brix.png" width="83" height="25" title="Built on Brix" /></a>
		</div>
	</div>
</center>
<script type="text/javascript">
	$(document).ready(function() {
		$('#update,#add,#delete,#cancel').button();
		if($('.error').length != 0){
			$('.error').prepend('<span class="ui-icon ui-icon-alert" style="float: left; margin-right: .3em;"></span>');
			$('.error').wrapInner('<p />');
			$('.error').wrapInner('<div class="ui-state-error" style="padding: 0 .7em;" />');
			$('.error').wrapInner('<div class="ui-widget" style="font-size:12px;" />');
		}
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
