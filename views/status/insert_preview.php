<h2>タスク登録確認</h2>
<p>この内容でタスク登録しますか？</p>


<form action = "<?php echo $base_url; ?>/status/insert" method="post">

    <input type="hidden" name="_token" value="<?php echo $this->escape($_token); ?>" />
    <input type="hidden" name="status_id" value="<?php switch ($status_name) {
        case "未処理":
            echo "1";
            break;
        case "仕掛中":
            echo "2";
            break;
        case "完了":
            echo "3";
            break;
    } ?>" />

    <?php if (isset($errors) && count($errors)>0): ?>
        <?php echo $this->render('errors',array('errors' => $errors)); ?>
    <?php endif; ?>

<table>
    <tr>
        <td>タスク名</td>
        <td><textarea  name="task_name" rows="2" cols="60" readonly><?php echo $this->escape($task_name); ?></textarea></td> <!--escapeはviewクラスのメソッド-->
    </tr>
    <tr>
        <td>期限</td>
        <td><textarea  name="deadline" rows="2" cols="60" readonly><?php echo $this->escape($deadline); ?></textarea></td>
    </tr>
    <tr>
        <td>ステータス</td>
        <td><textarea  name="status_name" rows="2" cols="60" readonly><?php echo $this->escape($status_name); ?></textarea></td>
    </tr>
</table>

<table>
    <tr>
        <td><input type="submit" value="登録する"/></td>
        <td><a href="<?php echo $base_url; ?>/status/insert_rend">キャンセル</a><td>
</table>

</form>
