<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?php if (isset($title)) : echo $this->escape($title) . ' - ' ; 
	endif ; ?>タスク一覧</title>
	<link rel="stylesheet" type="text/css" media="screen" href="css/style.css" />
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

