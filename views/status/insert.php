<?php $this->setLayoutVar('title','ホーム') ?>

<h2>タスク新規追加</h2>
<p>タスクを入力してください</p>

<form action = "<?php echo $base_url; ?>/status/insert_preview" method="post">
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
                <SELECT name="status_name">
                    <OPTION value= "未処理">未処理</OPTION><!--$status_id[0]の値を取得したい-->
                    <OPTION value="仕掛中">仕掛中</OPTION>
                    <OPTION value="完了">完了</OPTION>
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td><input type="submit" value="プレビュー"/></td>
            <td><a href="<?php echo $base_url; ?>">キャンセル</a><td>
    </table>





</form>

