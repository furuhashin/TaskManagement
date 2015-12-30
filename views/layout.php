<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php if (isset($title)) : echo $this->escape($title) . ' - ' ; 
	endif ; ?>タスク一覧</title>

	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<link href="js/tablesorter-master/dist/css/theme.default.min.css" rel="stylesheet">
	<script src="js/tablesorter-master/dist/js/jquery.tablesorter.min.js" type="text/javascript"></script>
	<script src="js/tablesorter-master/dist/js/jquery.tablesorter.widgets.min.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />

	<script>
		$(function(){
			$('table').tablesorter({
				headers			:{3: {sorter:false}},
				widgets        : ['zebra', 'columns'],
				usNumberFormat : false,
				sortReset      : true,
				sortRestart    : true
			});
		});
	</script>
</head>
<body>

	<div id = "main">
		<?php echo $_content; ?><!--取得結果の表示-->
	</div>

	<div id="nav">
		<p>
			<?php if ($session->isAuthenticated()): ?>

			<?php else: ?>
			<a href="<?php echo $base_url; ?>/account/signin">ログイン</a>
			<?php endif; ?>
		</p>
	</div>


</body>
</html>

