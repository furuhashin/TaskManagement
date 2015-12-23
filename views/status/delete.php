<?php $this->setLayoutVar('title','ホーム') ?>

<h2>タスク削除画面</h2>
<p>このタスクを削除しますか?</p>

<form action = "<?php echo $base_url; ?>/status/delete" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />

    <?php if (isset($errors) && count($errors)>0): ?>
        <?php echo $this->render('errors',array('errors' => $errors)); ?>
    <?php endif; ?>

    <table>
        <tr>
            <td>タスク名</td>
            <td><textarea name="task_name" rows="2" cols="60"><?php echo $this->escape($task_name); ?></textarea></td> <!--escapeはviewクラスのメソッド-->
        </tr>
        <tr>
            <td>期限</td>
            <td><textarea name="deadline" rows="2" cols="60"><?php echo $this->escape($deadline); ?></textarea></td>
        </tr>
        <tr>
            <td>ステータス</td>
            <td>
                td><textarea  name="status_name" rows="2" cols="60" readonly><?php echo $this->escape($status_name); ?></textarea></td>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td><input type="submit" value="プレビュー"/></td>
            <td><a href="<?php echo $base_url; ?>">キャンセル</a><td>
    </table>





</form>

