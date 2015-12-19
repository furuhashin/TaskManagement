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
		<?php echo $_content; ?>
	</div>

	<div id="nav">
		<p>
			<?php if ($session->isAuthenticated()): ?>
			<a href="<?php echo $base_url; ?>/">ホーム</a>
			<a href="<?php echo $base_url; ?>/account">アカウント</a>
			<?php else: ?>
			<a href="<?php echo $base_url; ?>/account/signin">ログイン</a>
			<?php endif; ?>
		</p>
	</div>

</body>
</html>

