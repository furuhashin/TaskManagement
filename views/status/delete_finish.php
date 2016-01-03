<h2>タスク削除完了</h2>
<p>タスクを削除しました</p>



<?php if (isset($errors) && count($errors)>0): ?>
    <?php echo $this->render('errors',array('errors' => $errors)); ?>
<?php endif; ?>

<table>
    <tr>
        <td>タスク名</td>
        <td><textarea name="task_name" rows="2" cols="60" readonly><?php echo $this->escape($task_name); ?></textarea></td>
    </tr>
    <tr>
        <td>期限</td>
        <td><textarea name="deadline" rows="2" cols="60" readonly><?php echo $this->escape($deadline); ?></textarea></td>
    </tr>
    <tr>
        <td>ステータス</td>
        <td><textarea name="deadline" rows="2" cols="60" readonly><?php echo $this->escape($status_name); ?></textarea></td>
    </tr>
</table>

<table>
    <tr>
        <td><a href="<?php echo $base_url; ?>">一覧へ戻る</a><td>
    </tr>
</table>




