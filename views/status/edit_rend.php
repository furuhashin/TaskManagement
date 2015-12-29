
<h2>タスク編集</h2>
<p>タスクを入力してください。</p>

<form action = "<?php echo $base_url; ?>/status/edit_preview/<?php echo $this->escape($statuses['id']); ?>" method="post">
    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
    <input type="hidden" name="id" value="<?php echo $this->escape($statuses['id']); ?>" />
    <?php if (isset($errors) && count($errors)>0): ?>
        <?php echo $this->render('errors',array('errors' => $errors)); ?>
    <?php endif; ?>

    <table>
        <tr>
            <td>タスク名</td>
            <td><textarea name="task_name" rows="2" cols="60"><?php echo $this->escape($statuses['task_name']); ?></textarea></td> <!--escapeはviewクラスのメソッド。$statusesはedit_previewAction()で作成される。-->
        </tr>
        <tr>
            <td>期限</td>
            <td><textarea name="deadline" rows="2" cols="60"><?php echo $this->escape($statuses['deadline']); ?></textarea></td>
        </tr>
        <tr>
            <td>ステータス</td>
            <td>
                <SELECT name="status_name">
                    <?php if ($this->escape($statuses['status_name']) == "未処理"):?>
                    <OPTION value= "未処理" selected>未処理</OPTION>
                    <OPTION value="仕掛中">仕掛中</OPTION>
                    <OPTION value="完了">完了</OPTION>
                    <?php elseif ($this->escape($statuses['status_name']) == "仕掛中"):?>
                    <OPTION value= "未処理" >未処理</OPTION>
                    <OPTION value="仕掛中" selected>仕掛中</OPTION>
                    <OPTION value="完了">完了</OPTION>
                    <?php elseif ($this->escape($statuses['status_name']) == "完了"):?>
                    <OPTION value= "未処理" >未処理</OPTION>
                    <OPTION value="仕掛中" >仕掛中</OPTION>
                    <OPTION value="完了" selected>完了</OPTION
                    <?php endif; ?>
            </td>
        </tr>
    </table>
    <table>
        <tr>

            <td><input type="submit" value="プレビュー"/></td>
            <td><a href="<?php echo $base_url; ?>">キャンセル</a><td>
    </table>



</form>

