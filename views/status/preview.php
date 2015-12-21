
<?php echo $_POST['task_name']; ?>
<?php echo $_POST['deadline']; ?>
<?php echo $_POST['status_id']; ?>
<input type="hidden" name="_statusid" value="<?php if ($status_id = "未処理"){ echo "1";}?>" /><!--これでDBに１が入る-->